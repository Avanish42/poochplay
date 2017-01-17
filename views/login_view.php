<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PoochPlay | </title>

    <!-- Bootstrap -->
    <link href="/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/assets/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Animate.css -->
    <link href="/assets/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/assets/css/custom.min.css" rel="stylesheet">

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
		<?php echo $this->session->flashdata('msg'); ?>
             <?php 
          $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform");
          echo form_open("login/index", $attributes);?>
		
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" id="txt_username" name="txt_username" value="<?php echo set_value('txt_username'); ?>"/>
		<span class="text-danger"><?php echo form_error('txt_username'); ?></span>
                    
              </div>
              <div>               
<input class="form-control" id="txt_password" name="txt_password" placeholder="Password" type="password" />
                    <span class="text-danger"><?php echo form_error('txt_password'); ?></span>
              </div>
		<input type="hidden" name="role" value="1"/>
              <div class="btn submit">
                <!--<a class="btn btn-default submit" href="index.html">Log in</a>-->
		<input id="btn_login" name="btn_login" type="submit" class="btn btn-default submit" value="Login" />	
                <!--<a class="reset_pass" href="#">Lost your password?</a>-->
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <!--<p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>-->

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Pooch Play</h1>
                  <p>©2016 All Rights Reserved. Pooch Play</p>
                </div>
              </div>
            <?php echo form_close(); ?>
          
          </section>
        </div>       
      </div>
    </div>
  </body>
</html>
