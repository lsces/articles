<?php
/**
 * @package articles
 */
namespace Bitweaver\Articles;

use Bitweaver\KernelTools;
global $gBitSystem, $gBitUser, $gBitSmarty;
$pRegisterHash = [
	'package_name' => 'articles',
	'package_path' => dirname( dirname( __FILE__ ) ).'/',
	'homeable' => true,
];

// fix to quieten down VS Code which can't see the dynamic creation of these ...
define( 'ARTICLES_PKG_NAME', $pRegisterHash['package_name'] );
define( 'ARTICLES_PKG_URL', BIT_ROOT_URL . basename( $pRegisterHash['package_path'] ) . '/' );
define( 'ARTICLES_PKG_PATH', BIT_ROOT_PATH . basename( $pRegisterHash['package_path'] ) . '/' );
define( 'ARTICLES_PKG_INCLUDE_PATH', BIT_ROOT_PATH . basename( $pRegisterHash['package_path'] ) . '/includes/');
define( 'ARTICLES_PKG_CLASS_PATH', BIT_ROOT_PATH . basename( $pRegisterHash['package_path'] ) . '/includes/classes/');
define( 'ARTICLES_PKG_ADMIN_PATH', BIT_ROOT_PATH . basename( $pRegisterHash['package_path'] ) . '/admin/');

$gBitSystem->registerPackage( $pRegisterHash );

if( $gBitSystem->isPackageActive( 'articles' ) ) {

	define( 'ARTICLE_STATUS_DENIED', 0 );
	define( 'ARTICLE_STATUS_DRAFT', 100 );
	define( 'ARTICLE_STATUS_PENDING', 200 );
	define( 'ARTICLE_STATUS_APPROVED', 300 );
	define( 'ARTICLE_STATUS_RETIRED', 400 );

	if( $gBitUser->hasPermission( 'p_articles_read' )) {
		$menuHash = [
			'package_name'       => ARTICLES_PKG_NAME,
			'index_url'          => ARTICLES_PKG_URL.'index.php',
			'menu_template'      => 'bitpackage:articles/menu_articles.tpl',
			'admin_comments_url' => ARTICLES_PKG_URL.'admin/admin_types.php',
		];
		$gBitSystem->registerAppMenu( $menuHash );
	}

	$gBitSystem->registerNotifyEvent( [ "article_submitted" => KernelTools::tra( "A user submits an article" ) ] );
}
