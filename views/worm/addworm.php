<html>
<head>
<title>Add Worm</title>
</head>
<body>
<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/addworm</h3>

<?php echo form_open_multipart('WebService/addworm');?>


worm_id*:<input type="text" name="worm_id" size="40" />
<br/>last_done:<input type="text" name="last_done" size="40" /> Long Value
<br />due_date:<input type="text" name="due_date" size="40" /> Long Value
<br />frequency:<input type="text" name="frequency" size="40" />
<br />user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br /> category*:<select name="category">
  <option value="lung_worm">lung_worm</option>
  <option value="tape_worm">tape_worm</option>
  <option value="flea_treatment">Flea_treatment</option>
  <option value="ticks_treatment">ticks_treatment</option>
  <option value="mites_treatment">mites_treatment</option>
  <option value="basic_worm ">basic_worm</option>
</select> 
<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

