{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

{include file=avviso_notice.tpl}

<table summary="help" width="90%" border="0" cellspacing="0" cellpadding="0">
<tr><td class="Normal" align="left">
		<div align="center">&nbsp;<br /><img src="tpl/black/help_30.gif" width="84" height="39" alt="{$showHelpTopic_langAltTitle|escape:"htmlall"|bbcode2html}" /></div>

{include file=Help/topic.tpl}

</td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}