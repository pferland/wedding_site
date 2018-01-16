{include file="head.tpl"}
	<tr>
		<td style="height: 94%; z-index:1000; position:relative;" class="style1">
			{foreach $error_array as $error}
				<h2 style="color: red">{$error}</h2>
			{/foreach}
			<script type="application/javascript">

                function CharacterCount() {
                    var message = document.getElementById('foodallergies');
                    var chars = message.value.length;

                    document.getElementById('characters').innerHTML = ( {$rsvp_comment_txt_limit} - chars );

                    if (chars > {$rsvp_comment_txt_limit}) {
                        message.value = message.value.substring(0, {$rsvp_comment_txt_limit});
                    }
                }

                function toggleGuest() {
                    var checkbox = document.getElementById('noguest');
					{foreach $number_allowed_guest_form_array as $entry}
						var guest_first_{$entry.number} = document.getElementById('guest_firstname_{$entry.number}');
						var guest_last_{$entry.number} = document.getElementById('guest_lastname_{$entry.number}');
						updateToggle_{$entry.number} = checkbox.checked ? guest_first_{$entry.number}.disabled=true : guest_first_{$entry.number}.disabled=false;
						updateToggle2_{$entry.number} = checkbox.checked ? guest_last_{$entry.number}.disabled=true : guest_last_{$entry.number}.disabled=false;
                    {/foreach}
                }
			</script>
			<form action="/rsvp.php" method="post">
				<h1 align="center" style="font-size: 73px" class="script_header">RSVP   {$number_allowed_guests}</h1>
				<table style="margin: auto; width: 70%; background-color: aliceblue; font-size: 23px; font-weight: bold;" class="table_bg">
					{if $number_allowed_guests > 0}
						<tr>
							<td>
								You are allocated to have {$number_allowed_guests} Guests.
							</td>
						</tr>
						<tr>
							<td>
								I do not have a guest <input type="checkbox" id="noguest" name="noguest" value="1" {$noguest|default:''} onclick="toggleGuest();" />
							</td>
						</tr>
					{elseif  $number_allowed_guests == 0 and $partnerfirstname == ""}
						<!-- -->
						<input type="hidden" id="noguest" name="noguest" value="1"/>
						<br>
					{else}
						<input type="hidden" name="noguest" value="1">
						<tr>
							<td>
								Your Guests Name is: {$title} {$partnerfirstname} {$partnerlastname}.
								<input type="hidden" name="guest_firstname" value="{$partnerfirstname}"/>
								<input type="hidden" name="guest_lastname" value="{$partnerlastname}"/>
								<input type="hidden" id="noguest" name="noguest" value="0"/>
							</td>
						</tr>
					{/if}

					{foreach $number_allowed_guest_form_array as $entry}
					<tr>
						<td style="text-align: center">
							Guest # {$entry.number}
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							First Name:
						</td>
						<td>
							{if $partnerfirstname != "" and $entry.number == 1}
								<input style="width:500px;" id="guest_firstname_{$entry.number}" name="guest_firstname_{$entry.number}" value="{$partnerfirstname}"/>
							{else}
							<input style="width:500px;" id="guest_firstname_{$entry.number}" name="guest_firstname_{$entry.number}" value=""/>
							{/if}
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							Last Name:
						</td>
						<td>
							{if $partnerlastname != "" and $entry.number == 1}
								<input style="width:500px;" id="guest_lastname_{$entry.number}" name="guest_lastname_{$entry.number}" value="{$partnerlastname}"/>
							{else}
								<input style="width:500px;" id="guest_lastname_{$entry.number}" name="guest_lastname_{$entry.number}" value=""/>
							{/if}
						</td>
					</tr>
					{/foreach}
					<tr>
						<td>
							Food Allergies for all party members:
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;height: 256px">
							<textarea id="foodallergies" name="foodallergies" style="width: 90%; height: 100%">{$foodallergies|default:''}</textarea>
						</td>
					</tr>
					<tr>
						<td align="right">
							<input type="reset" name="Clear" value="Clear" style="font-size: 23px">
						</td>
						<td>
							<input type="hidden" name="attending" value="{$attending}">
							<input type="hidden" name="firstname" value="{$firstname}">
							<input type="hidden" name="lastname" value="{$lastname}">
							<input type="hidden" name="comment" value="{$comment}">
							<input type="hidden" name="song_name" value="{$song_name}">
							<input type="hidden" name="song_artist" value="{$song_artist}">

							<input type="hidden" name="step" value="submit">
							<input id="submit" type="submit" name="Submit" style="font-size: 23px" value="Submit">
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
{include file="foot.tpl"}