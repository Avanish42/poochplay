<html>
<head>
<title>Is Complete Appointment</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/appointmentget</h3>

<?php echo form_open_multipart('WebService/appointmentget');?>


user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>
