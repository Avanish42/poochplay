
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Change Password</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>change password</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      	
			<?php 
			$attributes = array("class" => "form-horizontal", "id" => "userform", "name" => "userform");
				?>
			<fieldset>
			    <?php echo form_open("user/changepassword", $attributes)	?>
			    <div class="form-group">
			    <div class="row colbox">
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<label for="password" class="control-label">Password</label>
			    </div>
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<input id="password" name="password" placeholder="password" type="password" class="form-control" value="" />
				<span class="text-danger"><?php echo form_error('password'); ?></span>
			    </div>
			    </div>
			</div>
			    
			    <div class="form-group">
			    <div class="row colbox">
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<label for="retypepassword" class="control-label">Retype Password</label>
			    </div>
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<input id="retypepassword" name="retypepassword" placeholder="retypepassword" type="password" class="form-control" value="" />
				<span class="text-danger"><?php echo form_error('retypepassword'); ?></span>
			    </div>
			    </div>
			</div>
			    
			    <div class="form-group">
			    <div class="text-center">
				<input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save" />
				<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
			    </div>
			    </div>
			</fieldset>
			<?php echo form_close(); ?>
			<?php echo $this->session->flashdata('msg'); ?>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
