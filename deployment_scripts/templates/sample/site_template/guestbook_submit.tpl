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
			<table style="text-align:center; margin: auto; width: 70%; background-color: aliceblue; font-size: 23px; font-weight: bold;" class="table_bg">
				<tr>
					<th colspan="2">Guest Book Posts</th>
				</tr>
				<tr>
					<td>Name</td>
					<td>Date:</td>
				</tr>
				{foreach $guests as $guest}
					<tr>
						<td><a class="guestbooklink" href="{$site_url}guestbook.php?step=view&entry={$guest.id}">{$guest.name}</a></td>
						<td>{$guest.time}</td>
					</tr>
				{/foreach}
			</table>
		</td>
	</tr>
{include file="foot.tpl"}