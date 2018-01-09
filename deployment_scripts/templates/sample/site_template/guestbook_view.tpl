{include file="head.tpl"}
<tr>
	<td style="height: 94%; z-index:1000; position:relative;" class="style1">
		</br>
		</br>
		</br>
		</br>
		<table style="margin: auto; width: 70%; background-color: aliceblue; font-size: 23px; font-weight: bold;" class="table_bg">
			<tr>
				<th>Guest Book Post from <span class="guestname">{$guestname}</span> on <span class="guesttime">{$guesttime}</span></th>
			</tr>
		</table>
		</br>
		<table style="margin: auto; width: 70%; background-color: aliceblue; font-size: 23px; font-weight: bold;" class="table_bg">
			<tr>
				<th><h2>Message:</h2></th>
			</tr>
			<tr>
				<td>{$guestmessage}</td>
			</tr>
		</table>
	</td>
</tr>
{include file="foot.tpl"}