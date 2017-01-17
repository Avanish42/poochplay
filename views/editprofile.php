<html>
<head>
<title>Edit Profile</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/editprofile</h3>

<?php echo form_open_multipart('WebService/editprofile');?>


user_email*:<input type="text" name="user_email" size="40" />
<br />first_name:<input type="text" name="first_name" size="40" />
<br />last_name:<input type="text" name="last_name" size="40" />
<br />city:<input type="text" name="city" size="40" />
<br />mobileno:<input type="text" name="mobileno" size="40" />
<br />state:<input type="text" name="state" size="40" />
<br />postcode:<input type="text" name="postcode" size="40" />
<br />country:<input type="text" name="country" size="40" />
<!--<br />notification:<input type="text" name="notification" size="40" /> true/false-->
<br />door:<input type="text" name="door" size="40" />
<br />profile_pic:<input type="file" name="profile_pic" size="40" />


<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

