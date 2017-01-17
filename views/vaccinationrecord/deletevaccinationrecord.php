<html>
<head>
<title>Delete Vaccination Record</title>
</head>
<body>
<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/deletevaccinationrecord</h3>

<?php echo form_open_multipart('WebService/deletevaccinationrecord');?>


vacc_id*:<input type="text" name="vacc_id" size="40" />
<br />user_email*:<input type="text" name="user_email" size="40" />
<br />pet_id*:<input type="text" name="pet_id" size="40" />
<input type="submit" value="Submit" />

</form>

</body>
</html>

