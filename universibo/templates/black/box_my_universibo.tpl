{if $common_myLinksAvailable=="true"}
{include file=box_begin.tpl}
<table width="95%" border="0" cellspacing="1" cellpadding="0" align="center" summary="">
<tr><td colspan="3"><img src="tpl/black/myuniversibo_18.gif" width="89" height="22" alt="{$common_langMyUniversibo|escape:"htmlall"}" /></td></tr>
{foreach from=$common_myLinks item=temp_currLink}
<tr>
<td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
<td><img src="tpl/black/invisible.gif" width="4" height="1" alt="" /></td>
<td class="Menu" width="100%"><a href="{$temp_currLink.uri}">{$temp_currLink.label|lower|capitalize|escape:"htmlall"}</a>{if $temp_currLink.new=="true"}&nbsp;<img src="tpl/black/icona_new.gif" width="21" height="12" alt="!NEW!" />{/if}</td>
</tr>
{/foreach}
</table>
{include file=box_end.tpl}
{/if}