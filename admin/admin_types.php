<?php

// $Header$

require_once '../../kernel/includes/setup_inc.php';
use Bitweaver\KernelTools;
use Bitweaver\Articles\BitArticleType;

// Is package installed and enabled
$gBitSystem->verifyPackage( 'articles' );

// Now check permissions to access this page
$gBitSystem->verifyPermission( 'p_articles_admin' );

$artTypes = [
	'use_ratings'      => [
		'name' => KernelTools::tra( 'Rate' ),
		'desc' => KernelTools::tra( 'Allow ratings by the author' ),
	],
	'show_pre_publ'    => [
		'name' => KernelTools::tra( 'Show before publish date' ),
		'desc' => KernelTools::tra( 'non-admins can view before the publish date' ),
	],
	'show_post_expire' => [
		'name' => KernelTools::tra( 'Show after expire date' ),
		'desc' => KernelTools::tra( 'non-admins can view after the expire date' ),
	],
	'heading_only'     => [
		'name' => KernelTools::tra( 'Heading only' ),
		'desc' => KernelTools::tra( 'No article body, heading only' ),
	],
	'allow_comments'   => [
		'name' => KernelTools::tra( 'Comments' ),
		'desc' => KernelTools::tra( 'Allow comments for this type' ),
	],
	'show_image'       => [
		'name' => KernelTools::tra( 'Show image' ),
		'desc' => KernelTools::tra( 'Show topic or image' ),
	],
	'show_avatar'      => [
		'name' => KernelTools::tra( 'Show avatar' ),
		'desc' => KernelTools::tra( 'Show author\'s avatar' ),
	],
	'show_author'      => [
		'name' => KernelTools::tra( 'Show author' ),
		'desc' => KernelTools::tra( 'Show author\'s name' ),
	],
	'show_pubdate'     => [
		'name' => KernelTools::tra( 'Show publish date' ),
		'desc' => KernelTools::tra( 'Show publication date' ),
	],
	'show_expdate'     => [
		'name' => KernelTools::tra( 'Show expiration date' ),
		'desc' => KernelTools::tra( 'Show expiration date' ),
	],
	'show_reads'       => [
		'name' => KernelTools::tra( 'Show reads' ),
		'desc' => KernelTools::tra( 'Show the number of times an article has been read' ),
	],
	'show_size'        => [
		'name' => KernelTools::tra( 'Show size' ),
		'desc' => KernelTools::tra( 'Show the size of the article' ),
	],
	'creator_edit'     => [
		'name' => KernelTools::tra( 'Creator can edit' ),
		'desc' => KernelTools::tra( 'The person who submits an article of this type can edit it' ),
	],
];
$gBitSmarty->assign( 'artTypes', $artTypes );

$gContent = new BitArticleType( !empty( $_REQUEST['article_type_id'] ) ? $_REQUEST['article_type_id'] : NULL );

if( isset( $_REQUEST["add_type"] ) ) {
	$gContent->storeType( $_REQUEST );
} elseif( isset( $_REQUEST["remove_type"] ) ) {
	$gContent->removeType( $_REQUEST['remove_type'] );
} elseif( isset( $_REQUEST["update_type"] ) ) {
	foreach( array_keys( $_REQUEST["type_array"] ) as $this_type ) {
		$storeHash['article_type_id'] = $this_type;
		foreach( array_keys( $artTypes ) as $option ) {
			$storeHash[$option] = !empty( $_REQUEST[$option][$this_type] ) ? 'y' : 'n';
		}
		$storeHash['type_name'] = $_REQUEST['type_name'][$this_type];
		$gContent->storeType( $storeHash );
	}
}

$types = BitArticleType::getTypeList();
$gBitSmarty->assign( 'types', $types );

// Display the template
$gBitSystem->display( 'bitpackage:articles/admin_types.tpl',  KernelTools::tra('Edit Article Types') , [ 'display_mode' => 'admin' ]);
