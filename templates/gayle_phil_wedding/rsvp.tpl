{include file="head.tpl"}
	<tr>
		<td style="height: 94%; z-index:1000; position:relative;" class="style1">
			{foreach $error_array as $error}
				<h2 style="color: red">{$error}</h2>
			{/foreach}
			<script type="application/javascript">
                function toggleGuest() {
                    var checkbox = document.getElementById('noguest');
                    var guest_first = document.getElementById('guest_firstname');
                    var guest_last = document.getElementById('guest_lastname');
                    updateToggle = checkbox.checked ? guest_first.disabled=true : guest_first.disabled=false;
                    updateToggle2 = checkbox.checked ? guest_last.disabled=true : guest_last.disabled=false;
                }

                function toggleSong() {
                    var checkbox = document.getElementById('norequest');
                    var song_artist = document.getElementById('song_artist');
                    var song_name = document.getElementById('song_name');
                    updateToggle = checkbox.checked ? song_artist.disabled=true : song_artist.disabled=false;
                    updateToggle2 = checkbox.checked ? song_name.disabled=true : song_name.disabled=false;
                }
			</script>
			<form action="/rsvp.php" method="post">
				<h1 align="center" style="font-size: 73px" class="script_header">RSVP</h1>
				<table style="margin: auto; width: 70%; background-color: aliceblue; font-size: 23px; font-weight: bold;" class="table_bg">
					<tr>
						<td colspan="2">Please enter your name as it appears on the invitation.</td>
					</tr>
					<tr>
						<td style="text-align: center">
							Will you be attending?
						</td>
						<td>
							<input id="attending" type="radio" name="attending" value="yes" /> Accept with pleasure
							<input id="attending" type="radio" name="attending" value="no" /> Decline with regret
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							First Name:
						</td>
						<td>
							<input style="width:500px;" id="firstname" name="firstname" value="{$firstname|default:''}"/>
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							Last Name:
						</td>
						<td>
							<input style="width:500px;" id="lastname" name="lastname" value="{$lastname|default:''}"/>
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							Comment ( Will not be public )
						</td>
						<td>
							Maximum of 1024 Characters
						</td>
					</tr>
					<tr>
						<td colspan="2" style="height: 256px">
							<textarea id="comment" name="comment" style="width: 90%; height: 100%">{$comment|default:''}</textarea>
						</td>
					</tr>
					<tr>
						<td>
							I do not have a guest <input type="checkbox" id="noguest" name="noguest" value="1" {$noguest|default:''} onclick="toggleGuest();" />
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							Guest First Name:
						</td>
						<td>
							<input style="width:500px;" id="guest_firstname" name="guest_firstname" value="{$guest_firstname|default:''}"/>
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							Guest Last Name:
						</td>
						<td>
							<input style="width:500px;" id="guest_lastname" name="guest_lastname" value="{$guest_lastname|default:''}"/>
						</td>
					</tr>
					<tr>
						<td>
							Food Allergies for all party members:
						</td>
						<td>

						</td>
					</tr>
					<tr>
						<td colspan="2" style="height: 256px">
							<textarea id="foodallergies" name="foodallergies" style="width: 90%; height: 100%">{$foodallergies|default:''}</textarea>
						</td>
					</tr>
					<tr>
						<td>
							I do not have a song to request <input type="checkbox" name="norequest" id="norequest" value="1" {$norequest|default:''} onclick="toggleSong();" />
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							Song Artist:
						</td>
						<td>
							<input style="width:500px;" id="song_artist" name="song_artist" id="song_artist" value="{$song_artist|default:''}"/>
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							Song Name:
						</td>
						<td>
							<input style="width:500px;" id="song_name" name="song_name" id="song_name" value="{$song_name|default:''}"/>
						</td>
					</tr>
					<tr>
						<td align="right">
							<input type="reset" name="Clear" value="Clear" style="font-size: 23px">
						</td>
						<td>
							<input type="hidden" name="step" value="submit">
							<input id="submit" type="submit" name="Submit" style="font-size: 23px" value="Submit">
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
{include file="foot.tpl"}