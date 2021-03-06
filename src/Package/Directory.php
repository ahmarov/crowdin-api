<?php
/**
 * Crowdin API implementation in PHP.
 *
 * @copyright  Copyright (C) 2016 Nikolai Plath (elkuku)
 * @license    WTFPL - See license.txt
 */

namespace ElKuKu\Crowdin\Package;

use ElKuKu\Crowdin\Package;

/**
 * Class Directory
 *
 * @since  1.0.3
 */
Class Directory extends Package
{
	/**
	 * Add directory to Crowdin project.
	 *
	 * @param   string   $name      The name of the directory to add.
	 * @param   boolean  $isBranch  If set to 1 the directory will be marked as a version branch.
	 *                              Acceptable values are: 1 or 0.
	 * @param   string   $branch    The name of related version branch.
	 *
	 * @see https://crowdin.com/page/api/add-directory
	 * @since  1.0.3
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function add($name, $isBranch = false, $branch = '')
	{
		$parameters = ['name' => $name];

		if ($isBranch)
		{
			$parameters['is_branch'] = '1';
		}

		if ('' !== $branch)
		{
			$parameters['branch'] = $branch;
		}

		return $this->getHttpClient()
			->post($this->getBasePath('add-directory'), ['form_params' => $parameters]);
	}

	/**
	 * Rename directory or modify its attributes.
	 * When renaming directory the path can not be changed
	 * (it means new_name parameter can not contain path, name only).
	 *
	 * @param   string  $name           Full directory path that should be modified (e.g. /MainPage/AboutUs).
	 * @param   string  $newName        New directory name.
	 * @param   string  $title          New directory title to be displayed in Crowdin UI.
	 * @param   string  $exportPattern  New directory export pattern.
	 *                                  Is used to create directory name and path in resulted translations bundle.
	 * @param   string  $branch         The name of related version branch.
	 *
	 * @see   https://crowdin.com/page/api/change-directory
	 * @since 1.0.3
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function update($name, $newName = '', $title = '', $exportPattern = '', $branch = '')
	{
		$data = ['name' => $name];

		if ('' !== $newName)
		{
			$data['new_name'] = $newName;
		}

		if ('' !== $title)
		{
			$data['title'] = $title;
		}

		if ('' !== $exportPattern)
		{
			$data['export_pattern'] = $exportPattern;
		}

		if ('' !== $branch)
		{
			$data['branch'] = $branch;
		}

		return $this->getHttpClient()
			->post($this->getBasePath('change-directory'), ['form_params' => $data]);
	}

	/**
	 * Delete Crowdin project directory.
	 * All nested files and directories will be deleted too.
	 *
	 * @param   string  $name  The name of the directory to delete.
	 *
	 * @see   https://crowdin.com/page/api/delete-directory
	 * @since 1.0.3
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function delete($name)
	{
		return $this->getHttpClient()
			->post($this->getBasePath('delete-directory'), ['form_params' => ['name' => $name]]);
	}
}
