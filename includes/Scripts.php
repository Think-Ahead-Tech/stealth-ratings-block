<?php

namespace StealthRatings;

class Scripts {
	public static function init() {
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
	}

	public static function enqueue_scripts() {
		wp_enqueue_script( 'stealth-ratings-block-view', plugins_url( 'build/view.js', __FILE__ ), [], null, true );
		wp_localize_script(
			'stealth-ratings-block-view',
			'StealthRatingsBlock',
			[
				'nonce' => wp_create_nonce( 'wp_rest' )
			]
		);
	}
}
