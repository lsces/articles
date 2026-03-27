{* $Header$ *}
{strip}
{if $gBitSystem->isPackageActive( 'rss' ) && $gBitSystem->isFeatureActive( 'articles_rss' ) && $gBitSystem->getActivePackage() eq 'articles' && $gBitUser->hasPermission( 'p_articles_read' )}
	<link rel="alternate" type="application/rss+xml" title="{$gBitSystem->getConfig('articles_rss_title',"{tr}Articles{/tr} RSS")}" href="{$smarty.const.ARTICLES_PKG_URL}articles_rss.php?version={$gBitSystem->getConfig('rssfeed_default_version',0)}" />
{/if}
{/strip}
