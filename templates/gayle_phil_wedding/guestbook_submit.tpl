{include file="head.tpl"}
	<tr>
		<td style="height: 94% z-index:1000; position:relative;" class="style1">
			<table style="margin: auto; width: 50%; background-color: aliceblue">
				<tr>
					<th colspan="2" style="background-color: #C0C0C0">
						{$message}
					</th>
				</tr>
			</table>
			<table style="margin: auto; width: 50%; background-color: aliceblue">
				<tr>
					<th colspan="3">Guest Book Posts</th>
				</tr>
				<tr>
					<td>Date:</td>
					<td>Name</td>
					<td>Comment</td>
				</tr>
				{foreach $guests as $guest}
					<tr>
						<td>{$guest.time}</td>
						<td>{$guest.name}</td>
						<td>{$guest.message}</td>
					</tr>
				{/foreach}
			</table>
		</td>
	</tr>
{include file="foot.tpl"}