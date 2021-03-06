<?php
/**
 * Crowdin API implementation in PHP.
 *
 * @copyright  Copyright (C) 2016 Nikolai Plath (elkuku)
 * @license    WTFPL - See license.txt
 */

namespace ElKuKu\Crowdin\Package;

use ElKuKu\Crowdin\Languageproject;
use ElKuKu\Crowdin\Package;

/**
 * Class Project
 *
 * @since  1.0.5
 */
Class Project extends Package
{
	/**
	 * Create Crowdin project.
	 *
	 * @param   string           $login       The user login.
	 * @param   string           $accountKey  The user account key.
	 * @param   Languageproject  $project     The project object.
	 *
	 * @see https://crowdin.com/page/api/create-project
	 * @since 1.0.7
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function create($login, $accountKey, Languageproject $project)
	{
		$path = 'account/create-project?account-key=' . $accountKey;

		$params = $project->toQuery();

		$params[] = [
			'name'     => 'login',
			'contents' => $login
		];

		return $this->getHttpClient()
			->post($path, ['multipart' => $params]);
	}

	/**
	 * Edit Crowdin project.
	 *
	 * @param   Languageproject  $project  The language project object.
	 *
	 * @see https://crowdin.com/page/api/edit-project
	 * @since 1.0.7
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function edit(Languageproject $project)
	{
		$project->identifier = null;
		$project->source_language = null;

		return $this->getHttpClient()
			->post($this->getBasePath('edit-project'), ['multipart' => $project->toQuery()]);
	}

	/**
	 * Get Crowdin Project details.
	 *
	 * @param   string  $login       Your Crowdin Account login name.
	 * @param   string  $accountKey  Account API key (profile settings -> "API & SSO" tab).
	 *
	 * @see https://crowdin.com/page/api/get-projects
	 * @since 1.0.7
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getList($login, $accountKey)
	{
		$path = sprintf(
			'account/get-projects?account-key=%s&login=%s',
			$accountKey,
			$login
		);

		return $this->getHttpClient()
			->post($path);
	}

	/**
	 * Get Crowdin Project details.
	 *
	 * @since 1.0.5
	 * @see   https://crowdin.com/page/api/info
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getInfo()
	{
		return $this->getHttpClient()
			->post($this->getBasePath('info'));
	}

	/**
	 * Delete Crowdin project with all translations.
	 *
	 * @since 1.0.5
	 * @see   https://crowdin.com/page/api/delete-project
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function delete()
	{
		return $this->getHttpClient()
			->get($this->getBasePath('delete-project'));
	}
}
