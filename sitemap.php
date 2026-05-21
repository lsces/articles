<?php
/**
 * @package articles
 * @subpackage functions
 */

require_once '../kernel/includes/setup_inc.php';
use Bitweaver\Articles\BitArticle;

$gBitSystem->verifyPackage( 'articles' );

$gSiteMapHash = [];
$article = new BitArticle();
$listHash = [ 'max_records' => -1, 'sort_mode' => 'last_modified_desc' ];

if( $articles = $article->getList( $listHash ) ) {
	foreach( $articles as $row ) {
		if( empty( $row['display_url'] ) ) continue;
		$age = time() - $row['last_modified'];
		if( $age < 86400 )           $freq = 'daily';
		elseif( $age < 86400 * 7 )   $freq = 'weekly';
		else                          $freq = 'monthly';
		$gSiteMapHash[$row['content_id']] = [
			'loc'        => BIT_BASE_URI . $row['display_url'],
			'lastmod'    => date( 'Y-m-d', $row['last_modified'] ),
			'changefreq' => $freq,
			'priority'   => 0.7,
		];
	}
}

$gBitSmarty->assign( 'gSiteMapHash', $gSiteMapHash );
$gBitThemes->setFormatHeader( 'xml' );
header( 'Content-Type: application/xml; charset=utf-8' );
$gBitSystem->display( 'bitpackage:kernel/sitemap.tpl' );
