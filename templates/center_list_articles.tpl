<div class="display articles">
	{if !$articles}
		<div class="header">
			<h1>{tr}Articles{/tr}</h1>
		</div>
	{/if}

	{formfeedback success=$smarty.request.feedback|default:''}

	{include file="bitpackage:articles/article_filter_inc.tpl"}
	{if $gBitUser->hasPermission( 'p_articles_admin' ) and $futures}
		<h3>{tr}Upcoming Articles{/tr}</h3>
		<ul>
			{foreach from=$futures item=future}
				<li>{$future.display_link} <small>[ {tr}To be published{/tr}: {$future.publish_date|bit_long_datetime} ]</small></li>
			{/foreach}
		</ul>
	{/if}
	{if $gBitUser->hasPermission( 'p_articles_approve_submission' ) and $submissions}
		<h3>{tr}Submitted Articles{/tr}</h3>
		<ul>
			{foreach from=$submissions item=submission}
				<li>{$submission.display_link} <small>[ {tr}Submitted{/tr}: {$submission.last_modified|bit_long_datetime} ]</small></li>
			{/foreach}
		</ul>
	{elseif $submissions and $gBitSystem->isFeatureActive('articles_auto_approve') and $gBitUser->isRegistered()}
		<h3 style="margin-bottom:1em;">{tr}There are <a href="{$smarty.const.ARTICLES_PKG_URL}list.php?status_id={$smarty.const.ARTICLE_STATUS_PENDING}">more articles</a> that haven't made it here yet{/tr}</h3>
	{/if}

	{foreach from=$articles item=article}
		{include file="bitpackage:articles/article_display.tpl"}
	{foreachelse}
		<p class="norecords">
			{tr}No records found{/tr}<br />
			{if $gBitUser->hasPermission( 'p_articles_auto_approve' )}
				{assign var="ititle" value="Write article"}
			{else}
				{assign var="ititle" value="Submit article"}
			{/if}
			{if $topic}
				{smartlink ititle=$ititle ipackage=articles ifile="edit.php" topic="$topic"}
			{else}
				{smartlink ititle=$ititle ipackage=articles ifile="edit.php"}
			{/if}
		</p>
	{/foreach}
	{pagination}
</div>
