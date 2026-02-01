<?php
/**
 * @version $Header$
 * @package articles
 * @subpackage functions
 */

/**
 * Initialization
 */
	global $gContent;
use Bitweaver\Articles\BitArticle;
use Bitweaver\Articles\BitArticleTopic;
	
	// if we already have a gContent, we assume someone else created it for us, and has properly loaded everything up.
	if( empty( $gContent ) || !is_object( $gContent ) ) {
	$gContent = ( !empty( $_REQUEST['topic_id'] ) && is_numeric( $_REQUEST['topic_id'] ) ) ? new BitArticleTopic( $_REQUEST['topic_id'] ) : new BitArticleTopic();

		if( empty( $gContent->mTopicId ) ) {
			//handle legacy forms that use plain 'article' form variable name
		} else {
			$gContent->loadTopic();
		}
		$gBitSmarty->assign( 'gContent', $gContent );
	}
