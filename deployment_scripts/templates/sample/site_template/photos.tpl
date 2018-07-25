{include file="head.tpl"}
<tr>
	<td style="height: 94%" class="style1">
		<br />
		<br />
		<div align="center">
			<span class="details_header">Photographs</span>
			<table style="height: 75%; z-index: 1;position: relative;">
				<tr>
					<td>
						<div align="center">
							{assign var=row_count value=1}
							{foreach $filepaths as $filepath}
								<img height="400" src="{$filepath.photo_path}" alt="{$filepath.subtext}sadasdasd" />
								{assign var=row_count value=$row_count+1}
								{if $row_count == 3}
									</br>
									{assign var=row_count value=1}
								{/if}
							{/foreach}
						</div>
					</td>
				</tr>
			</table>
		</div>
	</td>
</tr>
{include file="foot.tpl"}