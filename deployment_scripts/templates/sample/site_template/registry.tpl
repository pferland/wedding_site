{include file="head.tpl"}
	<tr>
		<td style="height: 94%; z-index:1000; position:relative;" class="style1">
			<div align="center">
				{foreach $registry_links as $link}
					<a href="{$link.url}" target="_new"><img src="{$template_url}imgs/{$link.img_url}"></a>
				<br>
				{/foreach}
			</div>
		</td>
	</tr>
{include file="foot.tpl"}