<?php
// $Header$
// Copyright( c )2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See below for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.

/**
 * required setup
 */
namespace Bitweaver\Articles;

use Bitweaver\KernelTools;

require_once '../kernel/includes/setup_inc.php';

// Is package installed and enabled
$gBitSystem->verifyPackage( 'articles' );

// Now check permissions to access this page
$gBitSystem->verifyPermission( 'p_articles_read' );

if ( !empty( $_REQUEST['article_id'] ) ) {
	$param = [ 'article_id' => (int) $_REQUEST['article_id'] ];
	KernelTools::bit_redirect( BitArticle::getDisplayUrlFromHash( $param ) );
}

// Display the template
$gDefaultCenter = 'bitpackage:articles/center_list_articles.tpl';
$gBitSmarty->assign( 'gDefaultCenter', $gDefaultCenter );

// Display the template
$gBitSystem->display( 'bitpackage:kernel/dynamic.tpl', KernelTools::tra( 'Articles' ) , [ 'display_mode' => 'display' ]);
