<!--<style>
.form-group{text-align: center;}
.sbtn{margin-top: 20px}
.well{margin-top: 20px}
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Add/Update Story</legend>
        <?php
        $attributes = array("class" => "form-horizontal", "id" => "userform", "name" => "userform");
         
    ;?>
        <fieldset>
            <?php if ($story_id != 0)
        {
        echo form_open_multipart("story/update/" . $story_id, $attributes) ?>
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="story_id" class="control-label">Story ID</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="story_id" name="story_id" disabled="disabled" placeholder="story_id" type="text" class="form-control"  value="<?php echo $storyrecord[0]->id; ?>" />
                <span class="text-danger"><?php echo form_error('story_id'); ?></span>
            </div>
            </div>
            </div>
        <?php
         }
         else
         echo form_open_multipart("story/add", $attributes)    ?>
        <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="storytitle" class="control-label">Story Title*</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="storytitle" name="storytitle" placeholder="story title" type="text" class="form-control"  value="<?php if ($story_id == 0) echo set_value('storytitle'); else echo set_value('storytitle',$storyrecord[0]->title); ?>" />
                <span class="text-danger"><?php echo form_error('storytitle'); ?></span>
            </div>
            </div>
            </div>

             <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="storydescription" class="control-label">Story Description</label>
            </div>
            <div class="col-lg-8 col-sm-8"> 
		<?php $desc = $storyrecord[0]->description; 
		      //if (intval($story_id) != 0){ $desc = $storyrecord[0]->description; }?>
                <textarea id="storydescription" rows="10" cols="70" name="storydescription" class="form-control" > <?php echo $desc; ?></textarea>
                <span class="text-danger"><?php echo form_error('storydescription'); ?></span>
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
        <?php if(!empty($storyrecord[0]) && $storyrecord[0]->image_path != null && $story_id != 0){?>
        <img src="<?php echo $this->config->base_url().$storyrecord[0]->image_path;?>" alt="image" width="200"/>
        <?php } ?>
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
-->


<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Add Story</h3>
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
                    <h2>add story</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      
			    <?php if ($story_id != 0)
			{
			echo form_open_multipart("story/update/" . $story_id, $attributes) ?>
			    <div class="form-group">
			    <div class="row colbox">
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<label for="story_id" class="control-label">Story ID</label>
			    </div>
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<input id="story_id" name="story_id" disabled="disabled" placeholder="story_id" type="text" class="form-control"  value="<?php echo $storyrecord[0]->id; ?>" />
				<span class="text-danger"><?php echo form_error('story_id'); ?></span>
			    </div>
			    </div>
			    </div>
			<?php
			 }
			 else
			 echo form_open_multipart("story/add", $attributes)    ?>
			<div class="form-group">
			    <div class="row colbox">
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<label for="storytitle" class="control-label">Story Title*</label>
			    </div>
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<input id="storytitle" name="storytitle" placeholder="story title" type="text" class="form-control"  value="<?php if ($story_id == 0) echo set_value('storytitle'); else echo set_value('storytitle',$storyrecord[0]->title); ?>" />
				<span class="text-danger"><?php echo form_error('storytitle'); ?></span>
			    </div>
			    </div>
			    </div>

			     <div class="form-group">
			    <div class="row colbox">
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<label for="storydescription" class="control-label">Story Description</label>
			    </div>
			    <div class="col-md-6 col-sm-6 col-xs-12"> 
				<?php   $desc ="";
					if ($story_id != 0) 
					$desc = $storyrecord[0]->description; 

				      //if (intval($story_id) != 0){ $desc = $storyrecord[0]->description; }?>
				<textarea id="storydescription" rows="10" cols="70" name="storydescription" class="form-control" > <?php echo $desc; ?></textarea>
				<span class="text-danger"><?php echo form_error('storydescription'); ?></span>
			    </div>
			    </div>
			    </div>

			<div class="form-group">
			    <div class="row colbox">
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<label for="image" class="control-label">Image</label>
			    </div>
			    <div class="col-md-6 col-sm-6 col-xs-12">
				<input id="image" name="image" type="file" />
			    </div>
			<?php if(!empty($storyrecord[0]) && $storyrecord[0]->image_path != null && $story_id != 0){?>
			<img src="<?php echo $this->config->base_url().$storyrecord[0]->image_path;?>" alt="image" width="200"/>
			<?php } ?>
			    </div>
			    </div>         
		      
			 
			    <div class="form-group">
			    <div class="text-center">
				<input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save" />
				
			    </div>
			    </div>
			<?php echo form_close(); ?>
			<?php echo $this->session->flashdata('msg'); ?>


                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
