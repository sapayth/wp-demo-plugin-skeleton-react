<?php

namespace DemoPlugin\Traits;

use Exception;
use WP_Error;
use DemoPlugin\Exceptions\SheetSyncException;

trait RestResponseError {

	/**
	 * Send REST error response
	 *
	 * @since 1.0.0
	 *
	 * @param \Exception $e
	 * @param string     $default_message
	 *
	 * @return \WP_Error
	 */
	protected function send_response_error( Exception $e, $default_message = '' ) {
		if ( $e instanceof SheetSyncException ) {
			return new WP_Error(
				$e->get_error_code(),
				$e->get_message(),
				[ 'status' => $e->get_status_code() ]
			);
		}

		$default_message = $default_message ? $default_message : __( 'Something went wrong', 'demo-plugin' );

		return new WP_Error(
			'something_went_wrong',
			$default_message,
			[ 'status' => 422 ]
		);
	}
}
