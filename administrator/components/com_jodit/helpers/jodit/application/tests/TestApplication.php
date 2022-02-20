<?php
use Jodit\Application;
use Jodit\Consts;

/**
 * Class JoditRestTestApplication
 */
class JoditRestTestApplication extends Application {
	function checkAuthentication() {
		if (
			!in_array(@$_SERVER['REMOTE_ADDR'], [
				'172.17.0.1',
				'127.0.0.1',
				'::1',
				'[::1]',
			]) or isset($_GET['auth'])
		) {
			throw new ErrorException(
				'Need authorization',
				Consts::ERROR_CODE_FORBIDDEN
			);
		}
	}
}
