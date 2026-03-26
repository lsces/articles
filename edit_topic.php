<?php
/**
 * @version $Header$
 * @package articles
 * @subpackage functions
 */

/**
 * Initialization
 */
require_once '../kernel/includes/setup_inc.php';
use Bitweaver\Articles\BitArticle;
use Bitweaver\KernelTools;

include_once( ARTICLES_PKG_INCLUDE_PATH.'lookup_article_topic_inc.php' );

if ( !$gBitSystem->verifyPackage( 'articles' ) ) {
   $gBitSmarty->assign( 'msg', KernelTools::tra( "This package is disabled" ) . ": Articles" );
   $gBitSystem->display( "error.tpl" , NULL, [ 'display_mode' => 'edit' ]);
   die;
}

if( !$gContent->isValid() ) {
	$gBitSmarty->assign( 'msg', KernelTools::tra("Article topic not found") );
	$gBitSystem->display('error.tpl', NULL, [ 'display_mode' => 'edit' ]);
	die;
}

$gBitSmarty->assign( 'topic_info', $gContent->mInfo);

if( isset( $_REQUEST["fSubmitSaveTopic"] ) ) {
    $gContent->storeTopic( $_REQUEST );
	$gContent->loadTopic();
    KernelTools::bit_redirect( ARTICLES_PKG_URL . "admin/admin_topics.php" );
} elseif( isset( $_REQUEST['fRemoveTopicImage'] ) ) {
	$gContent->removeTopicImage();
}

$gBitSystem->display( 'bitpackage:articles/edit_topic.tpl' , NULL, [ 'display_mode' => 'edit' ]);
