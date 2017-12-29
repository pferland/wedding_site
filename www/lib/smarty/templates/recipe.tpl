{include file="header.tpl"}
<table>
	<tr>
		<td>
			<h2>{$Recipe.title}</h2>
		</td>
	</tr>
	<tr class="headers">
		<td>Description: </td>
	</tr>
	<tr class="data">
		<td>
			{$Recipe.description}
			<br>
			<br>
		</td>
	</tr>
	<tr class="headers">
		<td>Pictures</td>
	</tr>
	<tr class="data">
		<td>
			<table>
				<tr>
		{foreach $RecipePictures as $pictures}
					<td width="350px">
						<a href="pictures/{$pictures.filename}"><img width="320" src="pictures/{$pictures.filename}" alt="{$pictures.description}" title="{$pictures.description}" ></a><br>
						{$pictures.description}
					</td>
		{/foreach}
				</tr>
			</table>
			<br>
			<br>
		</td>
	</tr>
	<tr class="headers">
		<td>Ingredients: </td>
	</tr>
	<tr class="data">
		<td>
			{$Recipe.ingredients}
			<br>
			<br>
		</td>
	</tr>
	<tr class="headers">
		<td>Steps</td>
	</tr>
	<tr class="data">
		<td>
			{$Recipe.steps}
			<br>
			<br>
		</td>
	</tr>
</table>
{include file="footer.tpl"}