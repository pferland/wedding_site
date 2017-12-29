{include file="header.tpl"}
<form action="?func=create" method="post">
	<table width="75%">
		<tr>
			<td>
				Title: <input type="text" size="120" name="RecipeTitle">
			</td>
		</tr>
		<tr class="headers">
			<td>Description: </td>
		</tr>
		<tr class="data">
			<td>
				<textarea class="textareaDesc" name="RecipeDescription">

				</textarea>
				<br>
				<br>
			</td>
		</tr>
		<tr class="headers">
			<td>Pictures</td>
		</tr>
		<tr class="data">
			<td>
				<input type='file' name='uploadimages' accept="image/x-png,image/gif,image/jpeg" multiple/>
				<br>
				<br>
			</td>
		</tr>
		<tr class="headers">
			<td>Ingredients: </td>
		</tr>
		<tr class="data">
			<td>
				<textarea class="textarea" name="RecipeIngredients">

				</textarea>
				<br>
				<br>
			</td>
		</tr>
		<tr class="headers">
			<td>Steps</td>
		</tr>
		<tr class="data">
			<td>
				<textarea  class="textarea" name="RecipeSteps">

				</textarea>

				<br>
				<br>
			</td>
		</tr>
	</table>
</form>
{include file="footer.tpl"}