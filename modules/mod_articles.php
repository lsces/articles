<?php
/**
 * @version $Header$
 * @package articles
 * @subpackage modules
 */

/**
 * Initialization
 */
use Bitweaver\Articles\BitArticle;

extract( $moduleParams );

$articles = new BitArticle();
$stati = [ 'pending', 'approved' ];
$status_id = ( !empty( $module_params['status'] ) && in_array( $module_params['status'], $stati ) ) ? constant( 'ARTICLE_STATUS_' . strtoupper( $module_params['status'] ) ) : ARTICLE_STATUS_APPROVED;

$sortOptions = [
	"last_modified_asc",
	"last_modified_desc",
	"created_asc",
	"created_desc",
	"publish_date_desc",
	"publish_date_asc",
	"expire_date_desc",
	"expire_date_asc",
];
$sort_mode = ( !empty( $module_params['sort_mode'] ) && in_array( $module_params['sort_mode'], $sortOptions ) ) ? $module_params['sort_mode'] : 'last_modified_desc';

$getHash['status_id']     = $status_id;
$getHash['sort_mode']     = $sort_mode;
$getHash['max_records']   = !empty( $module_rows ) ? $module_rows : $gBitSystem->getConfig( 'articles_max_list' );
$getHash['topic_name']    = !empty( $module_params['topic_name'] ) ? $module_params['topic_name'] : NULL;
$getHash['topic_id']      = !empty( $module_params['topic_id'] ) ? $module_params['topic_id'] : NULL;
$articlelist = $articles->getList( $getHash );

if( ( !empty( $module_params['topic_id'] ) || !empty( $module_params['topic_name'] ) ) && empty($moduleParams['title']) && !empty( $articles ) ) {
	$gBitSmarty->assign( 'moduleTitle', $articlelist[0]['topic_name'] );
} elseif( !empty($moduleParams['title']) ) {
	$gBitSmarty->assign( 'moduleTitle', $moduleParams['title'] );
} else {
	$gBitSmarty->assign( 'moduleTitle', "Articles" );
}

$gBitSmarty->assign( 'params', !empty( $moduleParams['params'] ) );
$gBitSmarty->assign( 'listtype',  ( isset($module_params['list_type']) && (strncasecmp($module_params['list_type'], 'u', 1) == 0) ) ? 'ul' : 'ol' );
$gBitSmarty->assign( 'modArticles', $articlelist );
