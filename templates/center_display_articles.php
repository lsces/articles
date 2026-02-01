<?php
use Bitweaver\Users\RoleUser;

global $gBitSmarty, $gBitSystem, $gQueryUserId, $moduleParams, $gContent;
if ( !empty( $moduleParams ) ) {
	extract( $moduleParams );
}

include_once( ARTICLES_PKG_INCLUDE_PATH.'lookup_article_inc.php' );
include_once( ARTICLES_PKG_INCLUDE_PATH.'article_filter_inc.php' );

$listHash = [];

if ( $gBitUser->hasPermission( 'p_articles_admin' ) ) {
	$_REQUEST['status_id']   = !empty( $_REQUEST['status_id'] )   ? $_REQUEST['status_id']   : ARTICLE_STATUS_APPROVED;
	$_REQUEST['max_records'] = !empty( $_REQUEST['max_records'] ) ? $_REQUEST['max_records'] : $gBitSystem->getConfig( 'articles_max_list' );
	$_REQUEST['topic_id']    = !empty( $_REQUEST['topic_id'] )    ? $_REQUEST['topic_id']    : NULL;
	$_REQUEST['type_id']     = !empty( $_REQUEST['type_id'] )     ? $_REQUEST['type_id']     : NULL;

	$gBitSmarty->assign( 'futures', $gContent->getFutureList( $listHash ) );
} else {
	$_REQUEST['status_id']   = ARTICLE_STATUS_APPROVED;
	$_REQUEST['max_records'] = $gBitSystem->getConfig( 'articles_max_list' );
}
if ( !empty( $_REQUEST['topic'] ) ) {
	$gBitSmarty->assign( 'topic', $_REQUEST['topic'] );
}

if ( !empty( $moduleParams )) {
	$listHash = [ ...$_REQUEST, ...$moduleParams['module_params'] ];
	$listHash['max_records'] = $module_rows;
	//$listHash['parse_data'] = TRUE;
	//$listHash['load_comments'] = TRUE;
} else {
	$listHash = $_REQUEST;
}

RoleUser::userCollection( $_REQUEST, $listHash );

$articles = $gContent->getList( $listHash );
$gBitSmarty->assign( 'gContent', $gContent );
$gBitSmarty->assign( 'articles', $articles );
$gBitSmarty->assign( 'listInfo', $listHash['listInfo'] );

// show only descriptions on listing page
$gBitSmarty->assign( 'showDescriptionsOnly', TRUE );

// display submissions if we have the perm to approve them
if ( $gBitUser->hasPermission( 'p_articles_approve_submission' ) || ( $gBitSystem->isFeatureActive( 'articles_auto_approve' ) && $gBitUser->isRegistered() )) {
	$listHash = [ 'status_id' => ARTICLE_STATUS_PENDING ];
	$submissions = $gContent->getList( $listHash );
	$gBitSmarty->assign( 'submissions', $submissions );
}
