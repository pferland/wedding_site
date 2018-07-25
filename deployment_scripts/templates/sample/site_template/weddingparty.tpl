{include file="head.tpl"}
<tr>
	<td style="height: 94%" class="style1">
		<br />
		<br />
		<div align="center">
			<span class="details_header">Wedding Party</span>
			<table class="tablewall" style="z-index: 1;position: relative;">
				{foreach $filepaths as $filepath}
				<tr>
					<td class="cellwall"><img width="400" src="{$filepath.photo_path}" /></td>
				</tr>
				<tr>
					<td class="table_bg" style="text-align: center; font-size: 18px"><b>{$filepath.name}</b><br>{$filepath.title}</td>
				</tr>
				{/foreach}
			</table>
		</div>
		<br />
	</td>
</tr>
{include file="foot.tpl"}