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
 * Class Glossary
 *
 * @since  1.0.5
 */
Class Glossary extends Package
{
	/**
	 * Download Crowdin project glossaries as TBX file.
	 *
	 * @param   boolean  $includeAssigned  Defines whether the assigned glossaries should be included in downloaded TBX file.
	 *                                     Acceptable values are: 0, 1.
	 *                                     Default is 1.
	 *
	 * @since 1.0.5
	 * @see   https://crowdin.com/page/api/download-glossary
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function download($includeAssigned = true)
	{
		return $this->getHttpClient()
			->get($this->getBasePath('download-glossary') . '&include_assigned=' . (int) $includeAssigned);
	}

	/**
	 * Upload your Translation Memory for Crowdin Project in TMX file format.
	 *
	 * @param   string  $file  Full path to file to upload.
	 *
	 * @since 1.0.5
	 * @see   https://crowdin.com/page/api/upload-glossary
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function upload($file)
	{
		if (false === file_exists($file))
		{
			throw new \UnexpectedValueException('File not found for upload');
		}

		$data = [[
			'name'     => 'file',
			'contents' => fopen($file, 'r')
		]];

		return $this->getHttpClient()
			->post($this->getBasePath('upload-glossary'), ['multipart' => $data]);
	}
}
