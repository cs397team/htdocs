<html>

<h3 style="margin:0;display:inline;">Let's Make a Reservation!</h3>

<p>
<form>
<table>
<tr>
<td><b>Please choose a Date:</b></td>
<td><b>Please choose Time Range:</b></td>
</tr>

<tr>
<td><input type="date" name="date"></td>
<td>
	<table>
	<tr>
	<td>Access Time: </td>
	<td><input type="time" name="accessStart" step="1800"> to <input type="time" name="accessEnd"> </td>
	</tr>
	<tr>
	<td>Event Time: </td>
	<td><input type="time" name="startTime"> to <input type="time" name="endTime"></td>
	</tr>
	</table>
</td>

<tr>
<td>How often will this event occur?</td>
</tr>
<tr>
<td>
<select name="recurrence">
	<option value="once">Once</option>
	<option value="daily">Daily</option>
	<option value="weekly">Weekly</option>
	<option value="biWeekly">Bi-Weekly</option>
	<option value="monthly">Monthly</option>
</select>
</td>
</tr>
</table>

</br>
<input type="submit" value="Next">

</form>
</p>

</html>