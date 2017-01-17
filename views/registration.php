<html>
<head>
<title>Registration</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/register</h3>

<?php echo form_open('WebService/register');?>


email*:<input type="text" name="email" size="40" />
<br />password*:<input type="text" name="password" size="40" />
<br />firstname:<input type="text" name="firstname" size="40" />
<br />lastname:<input type="text" name="lastname" size="40" />
<br />os_type*:<input type="text" name="os_type" size="40" /> android/ios
<br />device_id*:<input type="text" name="device_id" size="40" />

<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

