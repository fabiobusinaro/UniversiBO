{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="" align="center">
<tr><td class="Normal">&nbsp;<br /> 
<p align="center" class="Titolo">{$ins_title|escape:"htmlall"}</p>

<p align="center">
{if $common_canaleMyUniversiBO == "remove"}
	<img src="tpl/black/esame_myuniversibo_del.gif" width="15" height="15" alt="" />&nbsp;
{else}<img src="tpl/black/esame_myuniversibo_add.gif" width="15" height="15" alt="" />&nbsp;
{/if}<a href="{$common_canaleMyUniversiBOUri|escape:"htmlall"}">{$common_langCanaleMyUniversiBO|escape:"htmlall"}</a>
</p>

{include file=tabellina_due_colonne.tpl arrayToShow=$ins_tabella}
&nbsp;<br />
{include file=News/latest_news.tpl}
</td></tr>
<tr><td class="Normal">&nbsp;<br />&nbsp;<br />
{include file=Files/show_file_titoli.tpl}

</td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}