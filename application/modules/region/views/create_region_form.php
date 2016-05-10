<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
  <div class="row">
    <div class="col-lg-4 col-lg-offset-4">

    <?php //echo validation_errors('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>',' </b></div>');?>
      <h1>Region Details</h1>
      <?php echo form_open('region/submit',array('class'=>'form-horizontal'));?>
      <div class="form-group">
        <?php
        echo form_label('Region Name','region_name');
        echo form_error('region_name');
        echo form_input(['name' => 'region_name', 'id' => 'region', 'pattern'=>'[a-zA-Z\s]+',  'value' =>  $region['region_name'] ,'class' => 'form-control', 'placeholder' => 'Enter Region Name']);
        ?>
      </div>
	  <div class="form-group">
        <?php
        echo form_label('Region Manager','region_manager');
        echo form_error('region_manager');
        echo form_input(['name' => 'region_manager', 'id' => 'region','pattern'=>'[a-zA-Z\s]+',  'value' => $details['manager'] ,'class' => 'form-control', 'placeholder' => 'Enter Name of Region Manager']);
        ?>
      </div>
	  <div class="form-group">
        <?php
        echo form_label('Mobile Phone of Region Manager','region_manager_phone');
        echo form_error('region_manager_phone');
        echo form_input(['name' => 'region_manager_phone','pattern'=>"[07]{2}[0-9]{8}", 'id' => 'region',  'value' => $details['manager_phone'] ,'class' => 'form-control', 'placeholder' => 'e.g. 0712345678' ]);
        ?>
      </div>
     
     <div class="form-group">
        <?php
        echo form_label('Email of Region Manager','region_manager_email');
        echo form_error('region_manager_email');
        echo form_input(['name' => 'region_manager_email', 'id' => 'region', 'pattern'=>"[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$", 'value' => $details['manager_email'] ,'class' => 'form-control', 'placeholder' => 'e.g. someone@example.com']);
        ?>
      </div>

      <div class="form-group">
          <?php
          echo form_label('WCBA Population (15-49)','women_population');
          echo form_error('women_population');
          echo form_input(['name' => 'women_population', 'type'=>'number', 'min'=>'0','id' => 'women_population',  'value' =>  $region['women_population'], 'class' => 'form-control']);
          ?>
        </div>  
        
        <div class="form-group">
          <?php
          echo form_label('Total Population','total_population');
          echo form_error('total_population');
          echo form_input(['name' => 'total_population','type'=>'number', 'min'=>'0', 'id' => 'total_population',  'value' => $region['total_population'], 'class' => 'form-control']);
          ?>
        </div>  
          
        <div class="form-group">
          <?php
          echo form_label('Population (Under 1 yr)','under_one_population');
          echo form_error('under_one_population');
          echo form_input(['name' => 'under_one_population','type'=>'number', 'min'=>'0', 'id' => 'under_one_population',  'value' => $region['under_one_population'], 'class' => 'form-control']);
          ?>
        </div>
     
      <div >
      <button class="btn btn-lg btn-danger btn-block" name="submit" type="submit">Submit</button>
      </div>
      <?php 
      if (isset($update_id)){
          echo form_hidden('update_id', $update_id);
      }
      echo form_close();?>
    </div>
  </div>
