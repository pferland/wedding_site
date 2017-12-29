{include file="header.tpl"}
	<table class="table_all">
		<tr>
			<th class="headers">
				Title
			</th>
			<th class="headers">
				Category
			</th>
			<th class="headers">
				Created By
			</th>
			<th class="headers">
				Created On
			</th>
		</tr>
		{foreach from=$recipes item="recipe"}
		<tr>
			<td class="data">
				<a href="recipe.php?hash={$recipe.hash}">{$recipe.title}</a>
			</td>
			<td class="data">
				{$recipe.category}
			</td>
			<td class="data">
				{$recipe.created_by}
			</td>
			<td class="data">
				{$recipe.created_on}
			</td>
		</tr>
		{/foreach}
	</table>
{include file="footer.tpl"}