<?php

use Bitweaver\KernelTools;
// $Header$
// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See below for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.
$formCmsSettings = [
	/*
		Feature is incomplete
		'articles_rankings' => [
			'label' => 'Rankings',
			'note' => 'Activates statistics for article ranking features.',
		],
	*/
	'articles_attachments'         => [
		'label' => 'File Attachments',
		'note'  => 'Allow the attachment of files to an article. This feature is required if you want to have individual article images.',
	],
	/*	'articles_content_attachments'  => [
			'label' => 'Content Attachments',
			'note' => 'Allow the attachment of content to an article.',
		],
	*/
	'articles_display_filter_bar'  => [
		'label' => 'Articles Filter',
		'note'  => 'Allows admins to quickly filter articles based on status, topic and type.',
	],
	'articles_submissions_rnd_img' => [
		'label' => 'Prevent Spam',
		'note'  => 'This will generate a random number as an image which the user has to confirm.',
	],
	'articles_auto_approve'        => [
		'label' => 'Auto Approve Articles',
		'note'  => 'Allow User ratings to Auto Approve Articles',
	],
];
$gBitSmarty->assign( 'formCmsSettings',$formCmsSettings );

$articleDateThreshold = [
	''       => KernelTools::tra( 'never' ),
	'always' => KernelTools::tra( 'always' ),
	'year'   => KernelTools::tra( 'up to a year' ),
	'month'  => KernelTools::tra( 'up to a month' ),
	'week'   => KernelTools::tra( 'up to a week' ),
	'day'    => KernelTools::tra( 'up to a day' ),
	'hour'   => KernelTools::tra( 'up to an hour' ),
];
$gBitSmarty->assign( 'articleDateThreshold', $articleDateThreshold );

$formArticleListing = [
	"articles_list_title"  => [
		'label' => 'Title',
		'note'  => 'List the title of the article.',
	],
	"articles_list_type"   => [
		'label' => 'Type',
		'note'  => 'Display what type of article it is.',
	],
	"articles_list_topic"  => [
		'label' => 'Topic',
		'note'  => 'Display the article topic.',
	],
	"articles_list_date"   => [
		'label' => 'Creation Date',
		'note'  => 'Display when the article was submitted first.',
	],
	"articles_list_expire" => [
		'label' => 'Expiration Date',
		'note'  => 'Display when the article will expire.',
	],
	"articles_list_author" => [
		'label' => 'Author',
		'note'  => 'Display the name of the author of an article.',
	],
	"articles_list_reads"  => [
		'label' => 'Hits',
		'note'  => 'Display the number of times a given article has been accessed.',
	],
	"articles_list_size"   => [
		'label' => 'Size',
		'note'  => 'Display the size of any given article.',
	],
	"articles_list_img"    => [
		'label' => 'Image',
		'note'  => 'Display the image that is associated with a given article.',
	],
	"articles_list_status" => [
		'label' => 'Status',
		'note'  => 'This will indicate whether a given article has been submitted or has been approved.',
	],
];
$gBitSmarty->assign( 'formArticleListing', $formArticleListing );
$gBitSmarty->assign( 'imageSizes', \Bitweaver\Liberty\get_image_size_options( FALSE ));

if( !empty( $_REQUEST['store_settings'] )) {
	$featureToggles = [ ...$formArticleListing,...$formCmsSettings ];
	foreach( $featureToggles as $item => $data ) {
		simple_set_toggle( $item, ARTICLES_PKG_NAME );
	}
	simple_set_int( "articles_max_list", ARTICLES_PKG_NAME );
	simple_set_int( "articles_description_length", ARTICLES_PKG_NAME );
	simple_set_value( "articles_image_size", ARTICLES_PKG_NAME );
}
