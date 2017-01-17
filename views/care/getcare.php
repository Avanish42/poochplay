<html>
<head>
<title>Care Get</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/getcare</h3>

<?php echo form_open_multipart('WebService/getcare');?>

<br /> category*:<select name="category">
  <option value="pee">pee</option>
  <option value="poo">poo</option>
  <option value="walk">walk</option>
  <option value="eat">eat</option>
  <option value="supplements">supplements</option>
  <option value="medication">medication</option>
  <option value="brush_groom_fur">brush_groom_fur</option>
  <option value="brush_teeth">brush_teeth</option>
  <option value="clean_ears">clean_ears</option>
  <option value="clip_nails">clip_nails</option>
  <option value="external_deworming">external_deworming</option>
  <option value="internal_deworming">internal_deworming</option>
  <option value="vaccination">vaccination</option>
  <option value="medication">medication</option>  
</select>
<br />user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>
