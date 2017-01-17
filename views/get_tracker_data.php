<html>
<head>
<title>Get Tracker Data</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/gettrackerdata</h3>

<?php echo form_open_multipart('WebService/gettrackerdata');?>

user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br />strdate*:<input type="text" name="strdate" size="40" /> (yyyy-mm-dd)
<br />enddate*:<input type="text" name="enddate" size="40" /> (yyyy-mm-dd)
 <br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

