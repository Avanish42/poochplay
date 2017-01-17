<html>
<head>
<title>Get Care, Vaccination, Worm</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/getcarevacworm</h3>

<?php echo form_open('WebService/getcarevacworm');?>


email*:<input type="text" name="email" size="40" />
<br/>pet_id*:<input type="text" name="pet_id" size="40" />

<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

