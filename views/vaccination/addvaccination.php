<html>
<head>
<title>Add Vaccination</title>
</head>
<body>
<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/addvaccination</h3>

<?php echo form_open_multipart('WebService/addvaccination');?>


vacc_id*:<input type="text" name="vacc_id" size="40" />
<br/>last_done:<input type="text" name="last_done" size="40" /> Long Value
<br />due_date:<input type="text" name="due_date" size="40" /> Long Value
<br />frequency:<input type="text" name="frequency" size="40" />
<br />user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<br /> category*:<select name="category">
  <option value="booster">booster</option>
  <option value="kennel_cough">kennel_cough</option>
  <option value="rabies">rabies</option>
</select> 
<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

