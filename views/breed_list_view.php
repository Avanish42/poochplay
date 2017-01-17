<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"  type="text/css">
  	 <script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
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
        	<legend>Breed List</legend>
            <table class="table table-striped table-hover" id="allusers">
                <thead>
                    <tr class="bg-primary">
                        <th>Breed id</th>
                        <th>Breed name</th>
                        <th>Remark</th>
						<th>Status</th>
						<th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($breed); $i++) { ?>
                    <tr>
                        <td><?php print_r($breed[$i] -> id); ?></td>
                        <td><?php echo $breed[$i] -> breed_name; ?></td>
                        <td><?php echo $breed[$i] -> remark; ?></td>
                        <td><?php echo $breed[$i] -> active_status; ?></td>
                        <td><a href="<?php echo base_url() . "breed/update/" . $breed[$i] -> id; ?>">Update</a></td>
                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

-->


<!-- DataTable-->	 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" type="text/css">

 <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>All Breeds</h3>
              </div>

              <!--<div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>-->

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>all breeds</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <table class="table table-striped jambo_table bulk_action" id="allusers">
			<thead>
		            <tr class="bg-primary">
		                <th>Breed id</th>
		                <th>Breed name</th>
		                <th>Remark</th>
							<th>Status</th>
							<th>Action</th>
		            </tr>
		        </thead>
		        <tbody>
		            <?php for ($i = 0; $i < count($breed); $i++) { ?>
		            <tr>
		                <td><?php print_r($breed[$i] -> id); ?></td>
		                <td><?php echo $breed[$i] -> breed_name; ?></td>
		                <td><?php echo $breed[$i] -> remark; ?></td>
		                <td><?php echo $breed[$i] -> active_status; ?></td>
		                <td><a href="<?php echo base_url() . "breed/update/" . $breed[$i] -> id; ?>">Update</a></td>
		                
		            </tr>
		            <?php } ?>
		        </tbody>
		    </table>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
