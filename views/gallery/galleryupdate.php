<html>
<head>
<title>Update Gallery</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/galleryupdate</h3>

<?php echo form_open_multipart('WebService/galleryupdate');?>

<br />user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br />title*:<input type="text" name="title" size="40" />
<br />gallery_id*:<input type="text" name="gallery_id" size="40" />
<br />description*:<input type="text" name="description" size="40" />

<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

