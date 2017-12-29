{include file="head.tpl"}
	<tr>
		<td style="height: 94%; z-index:1000; position:relative;" class="style1">
			<script language="javascript" type="text/javascript">

                function CharacterCount() {
                    var message = document.getElementById('message');
                    var chars = message.value.length;

                    document.getElementById('characters').innerHTML = ( {$guestbook_txt_limit} - chars );

                    if (chars > {$guestbook_txt_limit}) {
                        message.value = message.value.substring(0, {$guestbook_txt_limit});
                    }
                }
			</script>
			<form method="post" action="{$site_url}guestbook.php">
				<h1 align="center" style="font-size: 73px" class="script_header">Sign Guest Book</h1>
				<table style="margin: auto; width: 70%; background-color: aliceblue; font-size: 23px; font-weight: bold;" class="table_bg">
					<tr>
						<td style="text-align: center">
							Name:
						</td>
						<td>
							<input name="name"/>
						</td>
					</tr>
					<tr>
						<td style="text-align: center">
							Message
						</td>
						<td style="text-align: right;">
							<span id="characters">{$guestbook_txt_limit}</span> Characters Left
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;height: 256px">
							<textarea onkeyup="return CharacterCount();" onkeydown="return CharacterCount();" id="message" name="message" style=" width: 98%; height: 250px" ></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input type="reset" name="Clear" value="Clear"> |--|
							<input type="hidden" name="step" value="submit" >
							<input type="submit" name="Submit" value="Submit">
						</td>
					</tr>
				</table>
			</form>
			</br>
			</br>
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