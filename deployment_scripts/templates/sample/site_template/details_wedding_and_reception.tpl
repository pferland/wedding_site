{include file="head.tpl"}
	<tr>
		<td style="height: 94%; z-index:1000; position:relative;" class="style1">
			<h1 align="center" style="font-size: 73px" class="script_header">Wedding Details</h1>
			<span class="details_body">
			<table style="margin: auto; width: 75%;" class="details_table_body">
				<tr>
					<td class="style15">Wedding Location:</td>
					<td class="style13" style="width: 50%">{$wedding_location_name} {$wedding_town}</td>
				</tr>
				<tr>
					<td class="style15">Date:</td>
					<td class="style13" style="width: 50%">{$wedding_date}</td>
				</tr>
				<tr>
					<td class="style15">Wedding Time</td>
					<td class="style13" style="width: 50%">{$wedding_time}</td>
				</tr>
				<tr>
					<td class="style15">Wedding Attire:</td>
					<td class="style13" style="width: 50%">{$wedding_attire}</td>
				</tr>
			</table>
			<table style="margin: auto; width: 75%;" class="details_table_body">
				<tr>
					<td class="style15">Reception Location:</td>
					<td class="style13" style="width: 50%">{$reception_name} {$reception_town}</td>
				</tr>
				<tr>
					<td class="style15">Reception Date:</td>
					<td class="style13" style="width: 50%">{$reception_date}</td>
				</tr>
				<tr>
					<td class="style15">Reception Time</td>
					<td class="style13" style="width: 50%">{$reception_time}</td>
				</tr>
				<tr>
					<td class="style15">Reception Attire:</td>
					<td class="style13" style="width: 50%">{$reception_attire}</td>
				</tr>
			</table>
			<br />
			<table style="margin: auto; width: 75%;" class="details_table_body">
				<tr>
					<th> Wedding Location</th>
				</tr>
				<tr>
					<td>
						<iframe src="{$wedding_gmaps_link}" width=100%" height="480" frameborder="1" style="border:2px" allowfullscreen></iframe>
					</td>
				</tr>
			</table>
			<br />
			<table style="margin: auto; width: 75%;" class="details_table_body">
				<tr>
					<th> Reception Location</th>
				</tr>
				<tr>
					<td>
						<iframe src="{$reception_gmaps_link}" width=100%" height="480" frameborder="1" style="border:2px" allowfullscreen></iframe>
					</td>
				</tr>
			</table>
			<br />
			<table style="margin: auto; width: 75%;" class="details_table_body">
				<tr>
					<th> Hotel of choice <br/>{$hotel_name} <br><a href="{$hotel_room_link}">Click here for room booking</a></th>
				</tr>
				<tr>
					<td>
						<iframe src="{$hotel_gmaps_link}" width="100%" height="480" frameborder="1" style="border:2px" allowfullscreen></iframe>
					</td>
				</tr>
			</table>
			</span>
		</td>
	</tr>
{include file="foot.tpl"}