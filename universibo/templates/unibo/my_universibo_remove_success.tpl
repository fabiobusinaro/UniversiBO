{include file=header_index.tpl}

{include file=avviso_notice.tpl}

<div class="titoloPagina">
<h2>Rimuovi una pagina dal tuo MyUniversiBO<br />&nbsp;</h2>
<h4>La pagina &egrave; stata rimossa con successo.</h4>
</div>
<p><a href="{$common_canaleURI|escape:"htmlall"}">Torna&nbsp;a&nbsp;{$common_langCanaleNome}</a></p>

<hr />
{include file=Help/topic.tpl showTopic_topic=$showTopic_topic idsu=$showTopic_topic.reference}

{include file=footer_index.tpl}