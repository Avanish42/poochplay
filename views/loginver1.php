<html>
<head>
<title>Login Version 1</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/loginver1</h3>

<?php echo form_open('WebService/loginver1');?>


username*:<input type="text" name="username" size="40" />
<br />social_type*:<input type="text" name="social_type" size="40" /> facebook/google etc
<br />os_type*:<input type="text" name="os_type" size="40" /> android/ios
<br />device_id*:<input type="text" name="device_id" size="40" />

<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

