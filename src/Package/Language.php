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
 * Class Language
 *
 * @since  1.0.5
 */
Class Language extends Package
{
	/**
	 * Get supported languages list with Crowdin codes mapped to locale name and standardized codes.
	 *
	 * @since 1.0.5
	 * @see https://crowdin.com/page/api/supported-languages
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getSupported()
	{
		return $this->getHttpClient()
			->get('supported-languages');
	}

	/**
	 * Get the detailed translation progress for specified language.
	 *
	 * @param   string  $language  The language code.
	 *
	 * @since 1.0.5
	 * @see https://crowdin.com/page/api/language-status
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getStatus($language)
	{
		return $this->getHttpClient()
			->post($this->getBasePath('language-status'), ['form_params' => ['language' => $language]]);
	}
}
