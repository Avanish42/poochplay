<html>
<head>
<title>Get Pet</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/getpet</h3>

<?php echo form_open('WebService/getpet');?>


petid*:<input type="text" name="petid" size="40" />
<br />email*:<input type="text" name="email" size="40" />
<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>
