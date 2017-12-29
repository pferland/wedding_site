{include file="head.tpl"}
<tr style="margin: auto; width: 50%; background-color: aliceblue">
	<th colspan="2" style="background-color: #C0C0C0">
		<span style="z-index:1000; position:relative;">
		{foreach $error_array as $error}
			<h2 style="color: red">{$error}</h2>
		{/foreach}
		</span>
	</th>
</tr>
{include file="foot.tpl"}