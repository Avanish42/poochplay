<html>
<head>
<title>Add Tracker Data</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/addtrackerdata</h3>

<?php echo form_open_multipart('WebService/addtrackerdata');?>

user_email*:<input type="text" name="user_email" size="40" />
<br /><br />pet_id*:<input type="text" name="pet_id" size="40" />
<br /><br />tracker_data_json*:<textarea type="text" name="tracker_data_json" rows="4" cols="50"></textarea>
<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

