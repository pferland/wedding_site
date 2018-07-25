{include file="head.tpl"}
	<tr>
		<td style="height: 94%; z-index:1000; position:relative;" class="style1">
			<h1 align="center" style="font-size: 73px" class="script_header">Wedding Details</h1>
			<span class="details_body">
			<table style="margin: auto; width: 75%;" class="details_table_body">
				<tr>
					<td class="style15">Location:</td>
					<td class="style13" style="width: 50%">{$wedding_location_name} {$wedding_town}</td>
				</tr>
				<tr>
					<td class="style15">Date:</td>
					<td class="style13" style="width: 50%">{$wedding_date}</td>
				</tr>
				<tr>
					<td class="style15">Time</td>
					<td class="style13" style="width: 50%">{$wedding_time}</td>
				</tr>
				<tr>
					<td class="style15">Attire:</td>
					<td class="style13" style="width: 50%">{$wedding_attire}</td>
				</tr>
				<tr>
					<td class="style15">Other Information:</td>
					<td class="style13" style="width: 50%">{$other_info}</td>
				</tr>
			</table>
			<br />
			<table style="margin: auto; width: 75%;" class="details_table_body">
				<tr>
					<th style="font-size: 40px"> Wedding & Reception Location</th>
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
					<th style="font-size: 40px"> Hotel of choice</th>
				</tr>
				<tr>
					<th>{$hotel_name} <br>
						<a href="{$hotel_room_link}">Click here for room booking</a></br>
						Transportation will be provided from Hotel to Venue for the day of the wedding.
					</th>
				</tr>
				<tr>
					<td>
						<iframe src="{$hotel_gmaps_link}" width="100%" height="480" frameborder="1" style="border:2px" allowfullscreen></iframe>
					</td>
				</tr>
			</table>

			<br />
			<table style="margin: auto; width: 75%;" class="details_table_body">
				<tr>
					<th style="font-size: 40px">Friday Night Meet and Greet</th>
				</tr>
				<tr>
					<th>{$meet_greet_text}</th>
				</tr>
				<tr>
					<td>
						<iframe src="{$meet_greet_gmaps_link}" width="100%" height="480" frameborder="1" style="border:2px" allowfullscreen></iframe>
					</td>
				</tr>
			</table>

			<br />
			<table style="margin: auto; width: 75%;" class="details_table_body">
				<tr>
					<th style="font-size: 40px">Sunday Brunch</th>
				</tr>
				<tr>
					<th>{$brunch_text}</th>
				</tr>
				<tr>
					<td>
						<iframe src="{$brunch_gmaps_link}" width="100%" height="480" frameborder="1" style="border:2px" allowfullscreen></iframe>
					</td>
				</tr>
			</table>

			</span>
		</td>
	</tr>
{include file="foot.tpl"}