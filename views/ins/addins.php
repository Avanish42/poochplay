<html>
<head>
<title>Add Insurance</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/addins</h3>

<?php echo form_open_multipart('WebService/addins');?>

ins_id*:<input type="text" name="ins_id" size="40" />
<br />long_value*:<input type="text" name="long_value" size="40" />
<br />ins_provider*:<input type="text" name="ins_provider" size="40" />
<br />ins_policy_no*:<input type="text" name="ins_policy_no" size="40" />
<br />ins_upload:<input type="file" name="ins_upload" size="20" />
<br />ins_renewal_date:<input type="text" name="ins_renewal_date" size="40" />
<br />user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

