<html>
<head>
<title>worm Update</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/updateotherworm</h3>

<?php echo form_open_multipart('WebService/updateotherworm');?>
vacc_id*:<input type="text" name="vacc_id" size="40" />
<br />user_email*:<input type="text" name="user_email" size="40" />
<br />vaccination_name*:<input type="text" name="vaccination_name" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br />last_done:<input type="text" name="last_done" size="40" />
<br />due_date:<input type="text" name="due_date" size="40" />
<br />frequency:<input type="text" name="frequency" size="40" /> 
<br /><br />

<input type="submit" value="Submit" />

</form>

</body>
</html>
