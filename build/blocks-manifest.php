<?php
// This file is generated. Do not modify it manually.
return array(
	'build' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'stealth-ratings-block/stealth-ratings-block',
		'version' => '0.1.0',
		'title' => 'Stealth Ratings Block',
		'category' => 'widgets',
		'icon' => 'star-half',
		'description' => 'Add a stealth ratings block to your site.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'stealth-ratings-block',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./style-index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js',
		'attributes' => array(
			'businessName' => array(
				'type' => 'string',
				'default' => 'Your Business Name'
			),
			'externalUrl' => array(
				'type' => 'string',
				'default' => 'https://example.com'
			),
			'threshold' => array(
				'type' => 'number',
				'default' => 4
			)
		)
	)
);
