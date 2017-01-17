<html>
<head>
<title>Become Foster</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/becomefoster</h3>

<?php echo form_open_multipart('WebService/becomefoster');?>
<br />user_email*:<input type="text" name="user_email" size="40" />
<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

