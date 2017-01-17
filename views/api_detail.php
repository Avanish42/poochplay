<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Api Detail</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#accordion" ).accordion();
  } );
  </script>
  <style>
  h3{
    cursor:pointer;   
   }       
 </style>

</head>
<body>
    <h2>Api Detail</h2>
    <b>Note: All date will be in long format..</b>

<div id="accordion">
		<h3>Tracker Activity Section</h3>
      <div><p>
        <h4><a href="/apidetail/addtrackerdata">Add Tracker Data</a></h4>
        <h4><a href="/apidetail/gettrackerdata">Get Tracker Data</a></h4>
        </p>
      </div>

      <h3>Login/Registration/Forgot Password Section</h3>
      <div><p>
        <h4><a href="/apidetail/login">Login</a></h4>
        <h4><a href="/apidetail/registration">Registration</a></h4>
        <h4><a href="/apidetail/forgetpassword">Forget Password</a></h4>
        <h4><a href="/WebService/getbreed">Get Breed</a></h4>   
        <h4><a href="/apidetail/loginver1">Login Version1</a></h4>
        <h4><a href="/apidetail/editprofile">Edit Profile</a></h4>
        <h4><a href="/apidetail/resetpassword">Reset Password</a></h4>
        </p>
      </div>
      <h3>Pet Section </h3>
      <div>
        <p>
        <h4><a href="/apidetail/addpet">Add Pet</a></h4>
        <h4><a href="/apidetail/getpet">Get Pet</a></h4>
        <h4><a href="/apidetail/updatepet">Update Pet</a></h4>
        <h4><a href="/apidetail/deletepet">Delete Pet</a></h4>
        <h4><a href="/apidetail/getallpet">Get All Pet</a></h4>
        <h4><a href="/apidetail/sharepet">Share Pet</a></h4>
        </p>
      </div>
    <h3>Appointment Section </h3>
      <div>
        <p>
        <h4><a href="/apidetail/appointmentadd">Appointment Add</a></h4>
        <h4><a href="/apidetail/appointmentupdate">Appointment Update</a></h4>
        <h4><a href="/apidetail/appointmentdelete">Appointment Delete</a></h4>
        <h4><a href="/apidetail/appointmentiscomp">Appointment IsComplete</a></h4>
        <h4><a href="/apidetail/appointmentget">Appointment Get</a></h4>
        </p>
      </div>   
      <h3>Gallery Section </h3>
      <div>
        <p>
        <h4><a href="/apidetail/galleryadd">Gallery Add</a></h4>
        <h4><a href="/apidetail/galleryupdate">Gallery Update</a></h4>
        <h4><a href="/apidetail/gallerydelete">Gallery Delete</a></h4>
        <h4><a href="/apidetail/galleryget">Gallery Get </a></h4>
        </p>
      </div>
    <h3>Care Section </h3>
      <div>
        <p>
        <h4><a href="/apidetail/addcare">Add Care</a></h4>
        <h4><a href="/apidetail/getcare">Get Care</a></h4>
        <h4><a href="/apidetail/updatecare">Update Care</a></h4>
        <h4><a href="/apidetail/deletecare">Delete Care</a></h4>
        <h4><a href="/apidetail/iscompcare">IsComplete Care</a></h4>
        </p>
      </div> 
      <h3>Menstrual Cycle Section </h3>
      <div>
        <p>
            <h4><a href="/apidetail/mcadd">Add Menstrual Cycle</a></h4>
            <h4><a href="/apidetail/mcget">Get Menstrual Cycle</a></h4>
            <h4><a href="/apidetail/mcupdate">Update Menstrual Cycle</a></h4>
            <h4><a href="/apidetail/mcdelete">Delete Menstrual Cycle</a></h4>
        </p>
      </div>
    <h3>Insurance Section </h3>
      <div>
        <p>
    	<h4><a href="/apidetail/addins">Add Insurance</a></h4>
    	<h4><a href="/apidetail/getins">Get Insurance</a></h4>
    	<h4><a href="/apidetail/updateins">Update Insurance</a></h4>
    	<h4><a href="/apidetail/deleteins">Delete Insurance</a></h4>
        </p>
      </div> 
      <h3>Other Services Section</h3>
      <div><p>
           <h4><a href="/WebService/getstory">Get Story</a></h4>  
           <h4><a href="/apidetail/becomefoster">Become Foster</a></h4>
           <h4><a href="/apidetail/getcarevacworm">Get Care, Vacconation, Worm</a></h4>
        </p>
      </div>
    <h3>Vaccination Section</h3>
      <div><p>
        <h4><a href="/apidetail/addvaccination">Add Vaccination</a></h4>
        <h4><a href="/apidetail/getvaccination">Get Vaccination</a></h4>
        <h4><a href="/apidetail/updatevaccination">Update Vaccination</a></h4>
        <h4><a href="/apidetail/deletevaccination">Delete Vaccination</a></h4></p>
      </div>
     <h3>Other Vaccination Section</h3>
      <div><p>
        <h4><a href="/apidetail/addothervaccination">Add Other Vaccination</a></h4>
        <h4><a href="/apidetail/getothervaccination">Get Other Vaccination</a></h4>
        <h4><a href="/apidetail/updateothervaccination">Update Other Vaccination</a></h4>
        <h4><a href="/apidetail/deleteothervaccination">Delete Other Vaccination</a></h4></p>
      </div>
    <h3>Worm Section</h3>
      <div><p>
        <h4><a href="/apidetail/addWorm">Add Worm</a></h4>
        <h4><a href="/apidetail/getWorm">Get Worm</a></h4>
        <h4><a href="/apidetail/updateWorm">Update Worm</a></h4>
        <h4><a href="/apidetail/deleteWorm">Delete Worm</a></h4></p>
      </div>
     <h3>Vaccination Record/Book Section</h3>
      <div><p>
        <h4><a href="/apidetail/addvaccinationrecord">Add/Update Vaccination Record</a></h4>
        <h4><a href="/apidetail/getvaccinationrecord">Get Vaccination Record</a></h4>
        <h4><a href="/apidetail/deletevaccinationrecord">Delete Vaccination Record</a></h4>
      </div>
     <h3>Other Worm Section</h3>
      <div><p>
        <h4><a href="/apidetail/addotherworm">Add Other Worm</a></h4>
        <h4><a href="/apidetail/getotherworm">Get Other Worm</a></h4>
        <h4><a href="/apidetail/updateotherworm">Update Other Worm</a></h4>
        <h4><a href="/apidetail/deleteotherworm">Delete Other Worm</a></h4></p>
      </div>
    </div>
</body>
</html>

