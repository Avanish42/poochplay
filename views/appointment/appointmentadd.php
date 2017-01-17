<html>
<head>
<title>Add Appointment</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/appointmentadd</h3>

<?php echo form_open_multipart('WebService/appointmentadd');?>


appointment_id*:<input type="text" name="appointment_id" size="40" />
<br />appointment_title*:<input type="text" name="appointment_title" size="40" />
<br />appointment_time*:<input type="text" name="appointment_time" size="40" />
<br />appointment_date*:<input type="text" name="appointment_date" size="40" />
<br />appointment_loc*:<input type="text" name="appointment_loc" size="40" />
<br />user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br />is_done*:<input type="text" name="is_done" size="40" />

<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

