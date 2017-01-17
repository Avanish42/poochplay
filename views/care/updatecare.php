<html>
<head>
<title>Update Care</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/updatecare</h3>

<?php echo form_open_multipart('WebService/updatecare');?>


timer_id*:<input type="text" name="timer_id" size="40" />
<br />is_none:<input type="text" name="is_none" size="40" />
<br />date:<input type="text" name="date" size="40" />
<br />time:<input type="text" name="time" size="40" />
<br />long:<input type="text" name="long" size="40" />
<br />interval:<input type="text" name="interval" size="40" />
<br />user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br />is_comp:<input type="text" name="is_comp" size="40" />

<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>
