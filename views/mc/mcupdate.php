<html>
<head>
<title>Update Menstrual Cycle</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/updatemc</h3>

<?php echo form_open_multipart('WebService/updatemc');?>


start_date_id:<input type="text" name="start_date_id" size="40" />
<br />start_date_long:<input type="text" name="start_date_long" size="40" />
<br />end_date_id:<input type="text" name="end_date_id" size="40" />
<br />end_date_long:<input type="text" name="end_date_long" size="40" />
<br />expected_date_id:<input type="text" name="expected_date_id" size="40" />
<br />expected_date_long:<input type="text" name="expected_date_long" size="40" />
<br />notes:<input type="text" name="notes" size="40" />
<br />user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

