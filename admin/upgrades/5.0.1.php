<?php
/**
 * @package articles
 */

global $gBitInstaller;

$gBitInstaller->registerPackageUpgrade(
	[
		'package'     => 'articles',
		'version'     => '5.0.1',
		'description' => 'Widen articles.publish_date/expire_date from I4 to I8 — same schema shape as blogs\' matching pair (clearly copied from it), same latent Year-2038 overflow (I4 is a 32-bit signed integer, max value 19 January 2038). I8 matches the convention used everywhere else in this stack and has no such limit.',
	],
	[
		[ 'QUERY' => [
			'SQL92' => [
				"ALTER TABLE articles ALTER COLUMN publish_date TYPE BIGINT",
				"ALTER TABLE articles ALTER COLUMN expire_date TYPE BIGINT",
			],
		]],
	]
);
