<?php

namespace StealthRatings;

class Block {
	public static function init() {
		add_action( 'init', [ __CLASS__, 'register_block' ] );
	}

	public static function register_block() {
		register_block_type( dirname(__DIR__) . '/build' );
	}
}
