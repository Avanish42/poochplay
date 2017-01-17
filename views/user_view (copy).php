<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Add User Details</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "userform", "name" => "userform");
        echo form_open("user/index", $attributes);?>
        <fieldset>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="firstname" class="control-label">First Name</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="firstname" name="firstname" placeholder="firstname" type="text" class="form-control"  value="<?php echo set_value('firstname'); ?>" />
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
                <input id="lastname" name="lastname" placeholder="lastname" type="text" class="form-control"  value="<?php echo set_value('lastname'); ?>" />
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
                echo form_dropdown('role',$role,set_value('role'),$attributes);?>
                <span class="text-danger"><?php echo form_error('role'); ?></span>
            </div>
            </div>
            </div>
	    
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="email" class="control-label">Email</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="email" name="email" placeholder="email" type="email" class="form-control" value="<?php echo set_value('email'); ?>" />
                <span class="text-danger"><?php echo form_error('email'); ?></span>
            </div>
            </div>
            </div>
	    
	    <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="username" class="control-label">User Name</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="username" name="username" placeholder="username" type="text" class="form-control" value="<?php echo set_value('username'); ?>" />
                <span class="text-danger"><?php echo form_error('username'); ?></span>
            </div>
            </div>
            </div>
	    <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="password" class="control-label">Password</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="password" name="password" placeholder="password" type="password" class="form-control" value="<?php echo set_value('password'); ?>" />
                <span class="text-danger"><?php echo form_error('password'); ?></span>
            </div>
            </div>
            </div>
	    
	    
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="country" class="control-label">country</label>
            </div>
            <div class="col-lg-8 col-sm-8">
            
                <?php
                $attributes = 'class = "form-control" id = "country"';
                echo form_dropdown('country',$country, set_value('country'), $attributes);?>
                
                <span class="text-danger"><?php echo form_error('country'); ?></span>
            </div>
            </div>
            </div>
	    <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="state" class="control-label">state</label>
            </div>
            <div class="col-lg-8 col-sm-8">
            
                <?php
                $attributes = 'class = "form-control" id = "country"';
                echo form_dropdown('state',$state, set_value('state'), $attributes);?>
                
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
                <input id="city" name="city" placeholder="city" type="text" class="form-control"  value="<?php echo set_value('city'); ?>" />
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
                <input id="postcode" name="postcode" placeholder="postcode" type="text" class="form-control"  value="<?php echo set_value('postcode'); ?>" />
                <span class="text-danger"><?php echo form_error('postcode'); ?></span>
            </div>
            </div>
            </div>
            
            
            <div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
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
