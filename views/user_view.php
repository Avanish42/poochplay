<script type= "text/javascript" src="<?php echo base_url('assets/js/countries.js'); ?>"></script>
<script language="javascript">
	jQuery( document ).ready(function() {
		print_country("country");
	});

</script>
<style>
.form-group{text-align: center;}
.sbtn{margin-top: 20px}
.well{margin-top: 20px}
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Add/Update User Details</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "userform", "name" => "userform");
	       
	;?>
        <fieldset>
            <?php if ($user_id != 0)
	    {
	    echo form_open("user/update/" . $user_id, $attributes) ?>
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="user_id" class="control-label">User ID</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="user_id" name="user_id" disabled="disabled" placeholder="user_id" type="text" class="form-control"  value="<?php echo $userrecord[0]->id; ?>" />
                <span class="text-danger"><?php echo form_error('user_id'); ?></span>
            </div>
            </div>
            </div>
	    <?php
	     }
	     else
	     echo form_open("user/add", $attributes)	?>
	    <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="firstname" class="control-label">First Name</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="firstname" name="firstname" placeholder="firstname" type="text" class="form-control"  value="<?php if ($user_id == 0) echo set_value('firstname'); else echo set_value('firstname',$userrecord[0]->first_name); ?>" />
                <span class="text-danger"><?php echo form_error('firstname'); ?></span>
            </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="lastname" class="control-label">Last Name</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="lastname" name="lastname" placeholder="lastname" type="text" class="form-control"  value="<?php if ($user_id != 0) echo set_value('lastname',$userrecord[0]->last_name); else set_value('lastname') ?>" />
                <span class="text-danger"><?php echo form_error('lastname'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="role" class="control-label">Role</label>
            </div>
            <div class="col-lg-8 col-sm-8">
            
                <?php
                $attributes = 'class = "form-control" id = "role"';
                 if ($user_id != 0) echo form_dropdown('role',$role,set_value('role') ,$attributes); else echo form_dropdown('role',$role,set_value('role',$userrecord[0]->role_id) ,$attributes);?>
                <span class="text-danger"><?php echo form_error('role'); ?></span>
            </div>
            </div>
            </div>
	    
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="email" class="control-label">Email/Username</label>
            </div>
            <div class="col-lg-8 col-sm-8">
            
                <input id="email" name="email" 	<?php if ($user_id != 0) echo "disabled='disabled'"; ?> placeholder="email" type="email" class="form-control" value="<?php if ($user_id != 0) echo set_value('email',$userrecord[0]->email); ?>" />
                <span class="text-danger"><?php echo form_error('email'); ?></span>
            </div>
            </div>
            </div>
	    
	  
	    <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="password" class="control-label">Password</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="password" name="password" placeholder="password" type="password" class="form-control" value="<?php if ($user_id != 0) echo set_value('password',$userrecord[0]->password); else set_value('password');?>" />
                <span class="text-danger"><?php echo form_error('password'); ?></span>
            </div>
            </div>
            </div>
	    
	    
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="country" class="control-label">Country</label>
            </div>
            <div class="col-lg-8 col-sm-8">
            
                <?php
                $attributes = 'class = "form-control" id = "country"';
               // if ($user_id != 0) echo form_dropdown('country',$country, set_value('country',$userrecord[0]->country), $attributes); else echo form_dropdown('country',$country, set_value('country'), $attributes);?>
                <select onchange="print_state('state',this.selectedIndex);" id="country" name ="country" class="form-control">
			    <option >Select Country</option>
			</select
                <span class="text-danger"><?php echo form_error('country'); ?></span>
            </div>
            </div>
            </div>
	    <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="state" class="control-label">State</label>
            </div>
            <div class="col-lg-8 col-sm-8">
            
                <?php
                $attributes = 'class = "form-control" id = "country"';
                //if ($user_id != 0) echo form_dropdown('state',$state, set_value('state',$userrecord[0]->state), $attributes); else echo form_dropdown('state',$state, set_value('state'), $attributes);?>
                <select name ="state" id ="state" class="form-control">
				<option >Select State</option>
			</select>
                <span class="text-danger"><?php echo form_error('state'); ?></span>
            </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="city" class="control-label">City</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="city" name="city" placeholder="city" type="text" class="form-control"  value="<?php if ($user_id != 0) echo set_value('city',$userrecord[0]->city);else set_value('city'); ?>" />
                <span class="text-danger"><?php echo form_error('city'); ?></span>
            </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="postcode" class="control-label">Post Code</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="postcode" name="postcode" placeholder="postcode" type="text" class="form-control"  value="<?php if ($user_id != 0) echo set_value('postcode',$userrecord[0]->postcode);else set_value('postcode'); ?>" />
                <span class="text-danger"><?php echo form_error('postcode'); ?></span>
            </div>
            </div>
            </div>
            
            
            <div class="form-group">
            <div class="row colbox sbtn">
                <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save" />
                <!--<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />-->
            </div>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        <?php echo $this->session->flashdata('msg'); ?>
        </div>
    </div>
</div>
