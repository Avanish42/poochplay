<html>
<head>
<title>Forget Password</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/forgotpassword</h3>

<?php echo form_open('WebService/forgotpassword');?>


email*:<input type="text" name="email" size="40" />

<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

