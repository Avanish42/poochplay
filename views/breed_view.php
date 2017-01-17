<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title></title>
	<meta name="generator" content="LibreOffice 5.1.4.2 (Linux)"/>
	<meta name="created" content="00:00:00"/>
	<meta name="changed" content="2017-01-13T13:34:41.560173666"/>
	<style>
.form-group{text-align: center;}
.sbtn{margin-top: 20px}
.well{margin-top: 20px}
</style>


	<style type="text/css">
		h3.cjk { font-family: "Noto Sans CJK SC Regular" }
		h3.ctl { font-family: "FreeSans" }
		h2.cjk { font-family: "Noto Sans CJK SC Regular" }
		h2.ctl { font-family: "FreeSans" }
	</style>
</head>
<body lang="en-IN" dir="ltr">
<h3 class="western">Add Breed</h3>
<h2 class="western"><div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
              </h2>


<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Add/Update Breed</legend>
        <?php
        $attributes = array("class" => "form-horizontal", "id" => "userform", "name" => "userform");
          
    ;?>
        <fieldset>
            <?php if ($breed_id != 0)
        {
        echo form_open_multipart("breed/update/" . $breed_id, $attributes) ?>
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="breed_id" class="control-label">Breed ID</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="breed_id" name="breed_id" disabled="disabled" placeholder="breed_id" type="text" class="form-control"  value="<?php echo $breedrecord[0]->id; ?>" />
                <span class="text-danger"><?php echo form_error('breed_id'); ?></span>
            </div>
            </div>
            </div>
        <?php
         }
         else
         echo form_open_multipart("breed/add", $attributes)    ?>
        <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="breedname" class="control-label">Breed Name*</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="breedname" name="breedname" placeholder="breed name" type="text" class="form-control"  value="<?php if ($breed_id == 0) echo set_value('breedname'); else echo set_value('breedname',$breedrecord[0]->breed_name); ?>" />
                <span class="text-danger"><?php echo form_error('breedname'); ?></span>
            </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="remark" class="control-label">Remark</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="remark" name="remark" placeholder="remark" type="text" class="form-control"  value="<?php if ($breed_id != 0) echo set_value('remark',$breedrecord[0]->remark); else set_value('remark') ?>" />
                <span class="text-danger"><?php echo form_error('remark'); ?></span>
            </div>
            </div>
            </div>

            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="origin" class="control-label">Origin</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="origin" name="origin" placeholder="origin" type="text" class="form-control"  value="<?php if ($breed_id != 0) echo set_value('origin',$breedrecord[0]->origin); else set_value('origin') ?>" />
                <span class="text-danger"><?php echo form_error('origin'); ?></span>
            </div>
            </div>
            </div>

            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="lifespan" class="control-label">Life Span</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="lifespan" name="lifespan" placeholder="lifespan" type="text" class="form-control"  value="<?php if ($breed_id != 0) echo set_value('lifespan',$breedrecord[0]->life_span); else set_value('life span') ?>" />
                <span class="text-danger"><?php echo form_error('lifespan'); ?></span>
            </div>
            </div>
            </div>
           
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="weightmale" class="control-label">Weight Male</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="weightmale" name="weightmale" placeholder="weightmale" type="text" class="form-control"  value="<?php if ($breed_id != 0) echo set_value('weightmale',$breedrecord[0]->weight_male); else set_value('weight male') ?>" />
                <span class="text-danger"><?php echo form_error('weightmale'); ?></span>
            </div>
            </div>
            </div>
   
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="weightfemale" class="control-label">Weight Female</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="weightfemale" name="weightfemale" placeholder="weightfemale" type="text" class="form-control"  value="<?php if ($breed_id != 0) echo set_value('weightfemale',$breedrecord[0]->weight_female); else set_value('>weight female') ?>" />
                <span class="text-danger"><?php echo form_error('weightfemale'); ?></span>
            </div>
            </div>
            </div>


            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="heightmale" class="control-label">Height Male</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="heightmale" name="heightmale" placeholder="heightmale" type="text" class="form-control"  value="<?php if ($breed_id != 0) echo set_value('heightmale',$breedrecord[0]->height_male); else set_value('>height male') ?>" />
                <span class="text-danger"><?php echo form_error('heightmale'); ?></span>
            </div>
            </div>
            </div>
   
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="heightfemale" class="control-label">Height Female</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="heightfemale" name="heightfemale" placeholder="heightfemale" type="text" class="form-control"  value="<?php if ($breed_id != 0) echo set_value('heightfemale',$breedrecord[0]->height_female); else set_value('>height female') ?>" />
                <span class="text-danger"><?php echo form_error('heightfemale'); ?></span>
            </div>
            </div>
            </div>

            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="temperament" class="control-label">Temperament</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="temperament" name="temperament" placeholder="temperament" type="text" class="form-control"  value="<?php if ($breed_id != 0) echo set_value('temperament',$breedrecord[0]->temperament); else set_value('>temperament') ?>" />
                <span class="text-danger"><?php echo form_error('temperament'); ?></span>
            </div>
            </div>
            </div>

            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="target" class="control-label">Target</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="target" name="target" placeholder="target" type="text" class="form-control"  value="<?php if ($breed_id != 0) echo set_value('target',$breedrecord[0]->target); else set_value('>target') ?>" />
                <span class="text-danger"><?php echo form_error('target'); ?></span>
            </div>




            </div>
            </div>

            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="target" class="control-label">Manual Activity Taget</label>
            </div>
           <div class="col-lg-8 col-sm-8">
                <input id="manual" name="manual" placeholder="manual Target in minute" type="text" class="form-control"  value="<?php if ($breed_id != 0) echo set_value('manual',$breedrecord[0]->manual); else set_value('>manual') ?>" />
                <span class="text-danger"><?php echo form_error('manual'); ?></span>
            </div>
            </div>
            </div>



            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                 <label for="select" class="col-lg-2 control-label">Breed Categories</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <select name ="breed" class="form-control" id="select">
          
          <option value="">--Select-- </option>

          <option value="miniature">Miniature</option>

          <option value="samll">Small</option>
          <option value="medium">Medium</option>
          <option value="large">Large</option>
          <option value="gaint">Gaint</option>
        </select>
            </div>
            </div>
            </div>

        <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="image" class="control-label">Image</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="image" name="image" type="file" />
            </div>
		<?php if($breedrecord[0]->image_path != null && $breed_id != 0){?>
		<img src="<?php echo $this->config->base_url().$breedrecord[0]->image_path?>" alt="image" width="200"/>
		<?php } ?>
            </div>
            </div>

            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="active" class="control-label">Active</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <?php $status = var_export($breedrecord[0]->active_status,TRUE);  ?>
                <?php if ($breed_id != 0){ if($breedrecord[0]->active_status == 't'){  ?>
                    <input type="checkbox" name="active" id="active" checked="checked" class="form-control" value="true" />                   
                <?php }else{ ?>
                    <input type="checkbox" name="active" id="active" class="form-control" value="true" />
                <?php } }else{ ?>
                    <input type="checkbox" name="active" id="active" class="form-control" value="true" />
                <?php
                    }
                 ?>
               
            </div>
            </div>
            </div>
       
          
            <div class="form-group">
            <div class="row colbox sbtn">
                <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save" />
           </div>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        <?php echo $this->session->flashdata('msg'); ?>
        </div>
    </div>
</div>
              
<!-- <ul>
	<li/>
<p></p>
</ul> -->








</body>
</html>