<!-- HTML room reservation form -->
<html>

<body>
<h3>Reservation Time!</h3>

<form>
<table border ='0'>
<tr><td>Organization:</td><td><input type="text" name="organization"></td></tr>
<tr><td>Organization President:</td><td><input type="text" name="orgPres"></td></tr>
<tr><td>Oranization Advisor:</td><td><input type="text" name="orgAdvisor"></td></tr>
<tr><td>Contact Name:</td><td><input type="text" name="name"></td></tr>
<tr><td>Phone Number:</td><td><input type="tel" name="phone"></td></tr>
<tr><td>Email:</td><td><input type="email" name="email"></td></tr>
<tr><td>Alternate Contact Name:</td><td> <input type="text" name="name2"></td></tr>
<tr><td>Phone Number:</td><td> <input type="tel" name="phone2"></td></tr>
<tr><td>Email:</td><td> <input type="email" name="email2"></td></tr>
<tr><td>Event Title:</td><td> <input type="text" name="eventTitle" maxlength="40"></td></tr>
<tr><td>Event Type:</td><td> <select name="eventType">
		<option value="meeting">Meeting</option>
		<option value="study">Study Session</option>
		<option value="performance">Performance</option>
		<option value="meal">Meal</option>
		<option value="seminar">Seminar</option>
		<option value="conference">Conference</option>
		<option value="sportingEvent">Sporting Event</option>
		<option value="banquet">Banquet</option>
		<option value="fundraiser">Fundraiser</option>
		<option value="informationTable">Information Table</option>
		<option value="other">Other</option>
	</select></td></tr>
<tr><td>Event Date:</td><td> <input type="date" name="date"></td></tr>
<tr><td>Access Time:</td><td> <input type="time" name="accessStart"> to <input type="time" name="accessEnd"></td></tr>
<tr><td>Event Time:</td><td> <input type="time" name="startTime"> to <input type="time" name="endTime"></td></tr>
<tr><td>Event Description:</td><td> </br> <textarea rows="10" cols="50"></textarea></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>1st Choice of Facility</td></tr>
<tr><td>Building:</td><td> <input type="text" name="building"></td></tr>
<tr><td>Room Number/Name:</td><td> <input type="text" name="room"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>2nd Choice of Facility</td></tr>
<tr><td>Building:</td><td> <input type="text" name="room"></td></tr>
<tr><td>Room Number/Name:</td><td> <input type="text" name="room"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Expected Number of Participants:</td><td> <input type="number" name="participants"></td></tr>
<tr><td>Will tickets be sold?</td><td> 
	<input type="radio" name="ticketsCheck" value="yes"> Yes 
	<input type="radio" name="ticketCheck" value="no" checked="true"> No</td></tr>
<tr><td>Will prizes be awarded?</td><td>
	<input type="radio" name="prizesCheck" value="yes"> Yes 
	<input type="radio" name="prizesCheck" value="no" checked="true"> No</td></tr>
<tr><td>Will outside vendors sell goods at your event?</td><td>
	<input type="radio" name="vendorsCheck" value="yes"> Yes 
	<input type="radio" name="vendorsCheck" value="no" checked="true"> No</td></tr>
<tr><td>Will alcohol be served?</td><td>
	<input type="radio" name="alcoholCheck" value="yes"> Yes 
	<input type="radio" name="alcoholCheck" value="no" checked="true"> No</td></tr>
<tr><td>Will you have decorations?</td><td>
	<input type="radio" name="decorationsCheck" value="yes"> Yes 
	<input type="radio" name="decorationsCheck" value="no" checked="true"> No</td></tr>

</table>
<input type="submit" value="Submit Request">
	
</form>
</body>
</html>