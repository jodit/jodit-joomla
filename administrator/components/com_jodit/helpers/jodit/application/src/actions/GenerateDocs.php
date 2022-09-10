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

	private function docHTML(string $html): string {
		return <<<HTML
<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head><title>Document</title>
<!--[if gte mso 9]>
<xml>
<w:WordDocument>
<w:View>Print</w:View>
<w:Zoom>100</w:Zoom>
<w:DoNotOptimizeForBrowser/>
</w:WordDocument>
</xml>
<![endif]-->
<style><!--
@page
{
    size:21cm 29.7cmt;  /* A4 */
    margin:1cm 1cm 1cm 1cm; /* Margins: 2.5 cm on each side */
    mso-page-orientation: portrait;
}
@page Section1 { }
div.Section1 { page:Section1; }
--></style>
</head>
<body>
<div class=Section1>
<!--<br clear=all style='mso-special-character:line-break;page-break-before:always'>-->
{$html}
</div>
</body>
</html>
HTML;
	}
	public function actionGenerateDocx() {
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

		header("Content-Type: application/vnd.ms-word");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("content-disposition: attachment;filename=document.doc");
		echo $this->docHTML($html);
		die();
	}

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

		$paper = array_merge(
			[
				'format' => 'A4',
				'page_orientation' => 'portrait',
			],
			$this->request->options ?: []
		);

		$dompdf->setPaper($paper['format'], $paper['page_orientation']);
		$dompdf->render();
		$dompdf->stream();
		die();
	}
}
