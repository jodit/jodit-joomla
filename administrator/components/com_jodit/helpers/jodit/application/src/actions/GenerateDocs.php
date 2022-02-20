<?php

namespace Jodit\actions;

use Jodit\components\Config;
use Jodit\components\Request;
use Jodit\Consts;
use Dompdf\Dompdf;
use Exception;

/**
 * Trait GenerateDocs
 * @package Jodit\actions
 */
trait GenerateDocs {
	/**
	 * @var Request
	 */
	public $request;

	/**
	 * @var Config
	 */
	public $config;

	/**
	 * Generate pdf file from HTML
	 * @throws Exception
	 */
	public function actionGeneratePdf() {
		$this->config->access->checkPermission(
			$this->config->getUserRole(),
			$this->action,
			'/'
		);

		$html = $this->request->html;

		if (!$html) {
			throw new Exception(
				'Need html parameter',
				Consts::ERROR_CODE_BAD_REQUEST
			);
		}

		$dompdf = new Dompdf(['enable_remote' => true]);
		$dompdf->loadHtml($html);

		$paper =  array_merge([
			'format' => 'A4',
			'page_orientation' => 'portrait',
		], $this->request->options ?: []);

		$dompdf->setPaper($paper['format'], $paper['page_orientation']);
		$dompdf->render();
		$dompdf->stream();
		die();
	}
}
