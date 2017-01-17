<!-- DataTable-->	 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" type="text/css">

 <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>All Users</h3>
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
                    <h2>all users</h2>
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
		                <th>#</th>
		                <th>User id</th>
		                <th>First Name</th>
		                <th>Last Name</th>
		                <th>Email</th>
				<th>Post Code</th>
				<th>Country</th>
				<th>State</th>
				<th>City</th>
				<th>Post Code</th>
				<!--<th>Action</th>-->
		            </tr>
		        </thead>
		        <tbody>
		            <?php for ($i = 0; $i < count($userrecord); $i++) { ?>
		            <tr>
		                <td><?php echo ($i+1); ?></td>
		                <td><?php print_r($userrecord[$i]->id); ?></td>
		                <td><?php echo $userrecord[$i]->first_name; ?></td>
		                <td><?php echo $userrecord[$i]->last_name; ?></td>
		                <td><?php echo $userrecord[$i]->email; ?></td>
				<td><?php echo $userrecord[$i]->postcode; ?></td>
		                <td><?php echo $userrecord[$i]->country; ?></td>
		                <td><?php echo $userrecord[$i]->state; ?></td>
		                <td><?php echo $userrecord[$i]->city; ?></td>
				<td><?php echo $userrecord[$i]->postcode; ?></td>
		                <!--<td><a href="<?php echo base_url() . "user/delete/" . $userrecord[$i]->id; ?>">Delete</a> &nbsp; <a href="<?php echo base_url() . "user/update/" . $userrecord[$i]->id; ?>">Update</a></td>-->
		                
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
