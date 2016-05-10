<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
  <div class="row">
    <div class="col-lg-4 col-lg-offset-4">
       <?php 

      $array = array();
      foreach($counties as $row ){
         $array[$row->id] = $row->county_name;
       }
 
    ?>
      <h1>Add New Sub County</h1>
      <?php echo form_open('subcounty/submit',array('class'=>'form-horizontal'));?>
      <div class="form-group">
        <?php
        echo form_label('Sub County Name','subcounty_name');
        echo form_error('subcounty_name');
        echo form_input(['name' => 'subcounty_name', 'pattern'=>'[a-zA-Z\s]+', 'id' => 'subcounty',  'value' => $subcounty['subcounty_name'] ,'readonly' => '','class' => 'form-control', 'placeholder' => 'Enter Sub County Name']);
        ?>
      </div>
      <div class="form-group">
        <?php
        echo form_label('County Name','county_id');
        echo form_error('county_id');
        echo form_dropdown('county_id',$array , $subcounty['county_id'], 'id="county_id" class="form-control"'); 
        //echo form_input(['name' => 'county_id', 'id' => 'county_id',  'value' => $subcounty['county_id'] ,'class' => 'form-control', 'placeholder' => 'Enter County Name']);
        ?>
      </div>
       <div class="form-group">
        <?php
        echo form_label('Estimated Total Population','total_population');
        echo form_error('total_population');
        echo form_input(['name' => 'total_population', 'type'=>'number', 'min'=>'0', 'id' => 'total_population',  'value' => $subcounty['total_population'] ,'class' => 'form-control', 'placeholder' => 'Enter Population']);
        ?>
      </div>
       <div class="form-group">
        <?php
        echo form_label('Estimated Population Under One','under_one_population');
        echo form_error('under_one_population');
          echo form_input(['name' => 'under_one_population','type'=>'number', 'min'=>'0', 'id' => 'under_one_population',  'value' => $subcounty['under_one_population'] ,'class' => 'form-control', 'placeholder' => 'Enter Population']);
        ?>
      </div>
       <div class="form-group">
        <?php
        echo form_label('Estimated Population of Women','women_population');
        echo form_error('women_population');
        echo form_input(['name' => 'women_population', 'type'=>'number', 'min'=>'0','id' => 'women_population',  'value' => $subcounty['women_population'] ,'class' => 'form-control', 'placeholder' => 'Enter Population']);
        ?>
      </div>
     <div class="form-group">
        <?php
        // echo form_label('Number of Health Facilities','no_facilities');
        // echo form_error('no_facilities');
        // echo form_input(['name' => 'no_facilities', 'type'=>'number', 'min'=>'0','id' => 'no_facilities',  'value' => $details['no_facilities'] ,'class' => 'form-control', 'placeholder' => 'Enter Number']);
        ?>
      </div>
      <div >
      <button class="btn btn-lg btn-danger btn-block" name="submit" type="submit">Create Sub County</button>
      </div>
      <?php 
      if (isset($update_id)){
          echo form_hidden('update_id', $update_id);
      }
      echo form_close();?>
    </div>
  </div>
