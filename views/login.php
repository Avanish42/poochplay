<html>
<head>
<title>Login</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/login</h3>

<?php echo form_open('WebService/login');?>


username*:<input type="text" name="username" size="40" />
<br />password*:<input type="text" name="password" size="40" />
<br />os_type*:<input type="text" name="os_type" size="40" /> android/ios
<br />device_id*:<input type="text" name="device_id" size="40" />


<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

