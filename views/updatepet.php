<html>
<head>
<title>Update Pet</title>
</head>
<body>

<?php echo $error;?>
<h3>API URL: http://164.132.170.155/WebService/updatepet</h3>

<?php echo form_open_multipart('WebService/updatepet');?>


owner_name:<input type="text" name="owner_name" size="40" />
<br />country:<input type="text" name="country" size="40" />
<br />city:<input type="text" name="city" size="40" />
<br />postcode:<input type="text" name="postcode" size="40" />
<br />door:<input type="text" name="door" size="40" />
<br />user_email*:<input type="text" name="user_email" size="40" />
<br />petname*:<input type="text" name="petname" size="40" />
<br />petid*:<input type="text" name="petid" size="40" />
<br />breed_id*:<input type="text" name="breed_id" size="40" />
<br />sex:<input type="text" name="sex" size="40" />
<br />fathers_breed_id:<input type="text" name="fathers_breed_id" size="40" />
<br />mothers_breed_id:<input type="text" name="mothers_breed_id" size="40" />
<br />dob:<input type="text" name="dob" size="40" /> long value ex(135683336)
<br />current_weight:<input type="text" name="current_weight" size="40" />
<br />current_height:<input type="text" name="current_height" size="40" />
<br />microchip_id:<input type="text" name="microchip_id" size="40" />
<br />pet_type:<input type="text" name="pet_type" size="40" />
<br />lifestyle:<input type="text" name="lifestyle" size="40" />
<br />trained:<input type="text" name="trained" size="40" />
<br />neutred:<input type="text" name="neutred" size="40" />
<br />swimmer:<input type="text" name="swimmer" size="40" />
<br />temparement_ok_dog:<input type="text" name="temparement_ok_dog" size="40" />
<br />temparement_ok_cat:<input type="text" name="temparement_ok_cat" size="40" />
<br />temparement_ok_people:<input type="text" name="temparement_ok_people" size="40" />
<br />temparement_ok_child:<input type="text" name="temparement_ok_child" size="40" />
<br />petpic:<input type="file" name="petpic" size="20" />

<br />adoption_date:<input type="text" name="adoption_date" size="40" />
<br />spayed:<input type="text" name="spayed" size="40" />
<br />allergies:<input type="text" name="allergies" size="40" />
<br />medical_conditions:<input type="text" name="medical_conditions" size="40" />
<br />medicines:<input type="text" name="medicines" size="40" />
<br />likes:<input type="text" name="likes" size="40" />
<br />dislikes:<input type="text" name="dislikes" size="40" />
<br />incidents:<input type="text" name="incidents" size="40" />

<!--<br />ins_provider:<input type="text" name="ins_provider" size="40" />
<br />ins_policy_no:<input type="text" name="ins_policy_no" size="40" />
<br />ins_renewal_date:<input type="text" name="ins_renewal_date" size="40" />
<br />ins_upload:<input type="file" name="ins_upload" size="20" />-->

<br /><br />
<input type="submit" value="Submit" />

</form>

</body>
</html>

