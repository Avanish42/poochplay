<!-- <link rel="stylesheet" href="
https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"
type="text/css">
       <script type="text/javascript" src="
https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="
https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
<script>
    jQuery(function() {
        jQuery('#allusers').dataTable({
            //"User id": [[ 0, "desc" ]]
        });
    });
          </script>
<br><br>
<div class="container">
    <div class="row">
    <div class="col-md-3"></div>
        <div class="col-md-8">
            <legend>Foster List</legend>
            <table class="table table-striped table-hover" id="allusers">
                <thead>
                    <tr class="bg-primary">
                        <th>Foster id</th>
                        <th>Email</th>
            <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($foster); $i++) { ?>
                    <tr>
                        <td><?php print_r($foster[$i] -> id); ?></td>
                        <td><?php echo $foster[$i] -> email; ?></td>
                        <td><?php echo date("d-m-Y",strtotime($foster[$i] -> created_stamp));  
?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
-->



<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>All Stories</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>all stories</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content table-responsive">
                      <table class="table table-striped jambo_table bulk_action" id="allusers">
			 <thead>
		            <tr class="bg-primary">
		                <th>Foster id</th>
		                <th>Email</th>
						<th>Date</th>
		            </tr>
		        </thead>
		        <tbody>
		            <?php for ($i = 0; $i < count($foster); $i++) { ?>
		            <tr>
		                <td><?php print_r($foster[$i] -> id); ?></td>
		                <td><?php echo $foster[$i] -> email; ?></td>
		                <td><?php echo date("d-m-Y",strtotime($foster[$i] -> created_stamp));  
	?></td>
		            </tr>
		            <?php } ?>
		        </tbody>
		    </table>
			
			<form action="notification/sendfcm" >
			<input type="submit" value="Send Push"/>
			</form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<!--
		<script src="https://www.gstatic.com/firebasejs/3.6.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/3.6.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/3.6.1/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/3.6.1/firebase-messaging.js"></script>

<script src="https://www.gstatic.com/firebasejs/3.6.2/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyAaniRlpAAjxnEdoPeTqAImGr-1T76RKnw",
    authDomain: "fir-poochplay.firebaseapp.com",
    databaseURL: "https://fir-poochplay.firebaseio.com",
    storageBucket: "firebase-poochplay.appspot.com",
    messagingSenderId: "382444131811"
  };
  firebase.initializeApp(config);
</script>-->
