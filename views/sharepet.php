<html>
<head>
<title>Share Pet</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/sharepet</h3>

<?php echo form_open_multipart('WebService/sharepet');?>

owner_email*:<input type="text" name="owner_email" size="40" />
<br />shared_email*:<input type="text" name="shared_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>
