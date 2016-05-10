<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
  <div class="row">
    <div class="col-lg-4 col-lg-offset-4">
     <?php 

      $array = array();
      foreach($regions as $row ){
         $array[$row->id] = $row->region_name;
       }
 
    ?>
      <h1>Edit County Details</h1>
      <?php echo form_open('county/submit',array('class'=>'form-horizontal'));?>
      <div class="form-group">
        <?php
        echo form_label('County Name','county_name');
        echo form_error('county_name');
        echo form_input(['name' => 'county_name', 'id' => 'county',  'value' => $county['county_name'] ,'class' => 'form-control disabled', 'placeholder' => 'Enter County Name', 'readonly'=>'true']);
        ?>
      </div>
      <div class="form-group">
        <?php
        echo form_label('County Headquarter','county_headquarter');
        echo form_error('county_headquarter');
        echo form_input(['name' => 'county_headquarter', 'id' => 'county_headquarter', 'pattern'=>'[a-zA-Z\s]+', 'value' => $details['county_headquarter'] ,'class' => 'form-control', 'placeholder' => 'Enter County Headquarter']);
        ?>
      </div>
      <div class="form-group">
        <?php
        echo form_label('Region','region_id');
        echo form_error('region_id');
        //echo form_input(['name' => 'region_id', 'id' => 'region_id',  'value' => $region_id ,'class' => 'form-control', 'placeholder' => 'Enter Region']);
        echo form_dropdown('region_id',$array , $details['region_id'], 'id="region_id" class="form-control"'); 
        ?>
      </div>
	  <div class="form-group">
        <?php
        echo form_label('Estimated Total Population','total_population');
        echo form_error('total_population');
        echo form_input(['name' => 'total_population','type'=>'number' ,'min'=>'1', 'id' => 'total_population',  'value' => $county['total_population'] ,'class' => 'form-control', 'placeholder' => 'Enter Population']);
        ?>
      </div>
       <div class="form-group">
        <?php
        echo form_label('Estimated Population Under One','under_one_population');
        echo form_error('under_one_population');
        echo form_input(['name' => 'under_one_population','type'=>'number' ,'min'=>'1', 'id' => 'under_one_population',  'value' => $county['under_one_population'] ,'class' => 'form-control', 'placeholder' => 'Enter Population']);
        ?>
      </div>
       <div class="form-group">
        <?php
        echo form_label('Estimated Population of Women','women_population');
        echo form_error('women_population');
        echo form_input(['name' => 'women_population', 'type'=>'number' ,'min'=>'0','id' => 'women_population',  'value' => $county['women_population'] ,'class' => 'form-control', 'placeholder' => 'Enter Population']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('County EPI Logistician','county_logistician');
        echo form_error('county_logistician');
        echo form_input(['name' => 'county_logistician', 'id' => 'county_logistician', 'pattern'=>'[a-zA-Z\s]+', 'value' => $details['county_logistician'] ,'class' => 'form-control', 'placeholder' => 'Enter Name of County EPI Logistician']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('Mobile Phone Number of EPI Logistician','county_logistician_phone');
        echo form_error('county_logistician_phone');
        echo form_input(['name' => 'county_logistician_phone','id' => 'county_logistician_phone',  'pattern'=>"[07]{2}[0-9]{8}" , 'value' => $details['county_logistician_phone'] ,'class' => 'form-control', 'placeholder' => 'e.g. 0712345678']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('Email Address of EPI Logistician','county_logistician_email');
        echo form_error('county_logistician_email');
        echo form_input(['name' => 'county_logistician_email', 'id' => 'county_logistician_email', 'pattern'=>"[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$",  'value' => $details['county_logistician_email'] ,'class' => 'form-control', 'placeholder' => 'e.g. someone@example.com']);
        ?>
      </div>
	  
	  
	  
	  <div class="form-group">
        <?php
        echo form_label('County Public Health Nurse','county_nurse');
        echo form_error('county_nurse');
        echo form_input(['name' => 'county_nurse', 'id' => 'county_nurse', 'pattern'=>'[a-zA-Z\s]+', 'value' => $details['county_nurse'] ,'class' => 'form-control', 'placeholder' => 'Enter Name of County Public Health Nurse']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('Mobile Phone Number of County Public Health Nurse','county_nurse_phone');
        echo form_error('county_nurse_phone');
        echo form_input(['name' => 'county_nurse_phone', 'id' => 'county_nurse_phone' ,'pattern'=>"[07]{2}[0-9]{8}"  ,'value' => $details['county_nurse_phone'] ,'class' => 'form-control', 'placeholder' => 'e.g. 0712345678']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('Email Address of County Public Health Nurse','county_nurse_email');
        echo form_error('county_nurse_email');
        echo form_input(['name' => 'county_nurse_email', 'id' => 'county_nurse_email', 'pattern'=>"[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$", 'value' => $details['county_nurse_email'] ,'class' => 'form-control', 'placeholder' => 'e.g. someone@example.com']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('Name of Medical Engineering Technician','medical_technician');
        echo form_error('medical_technician');
        echo form_input(['name' => 'medical_technician', 'id' => 'medical_technician', 'pattern'=>'[a-zA-Z\s]+', 'value' => $details['medical_technician'] ,'class' => 'form-control', 'placeholder' => 'Enter Name of Medical Engineering Technician']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('Mobile Phone Number of Medical Engineering Technician','medical_technician_phone');
        echo form_error('medical_technician_phone');
        echo form_input(['name' => 'medical_technician_phone', 'id' => 'medical_technician_phone','pattern'=>"[07]{2}[0-9]{8}" ,  'value' => $details['medical_technician_phone'] ,'class' => 'form-control', 'placeholder' => 'e.g. 0712345678']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('Email Address of Medical Engineering Technician','medical_technician_email');
        echo form_error('medical_technician_email');
        echo form_input(['name' => 'medical_technician_email','pattern'=>"[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$", 'id' => 'medical_technician_email',  'value' => $details['medical_technician_email'] ,'class' => 'form-control', 'placeholder' => 'e.g. someone@example.com']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('Name of County Medical Officer','county_medical_officer');
        echo form_error('county_medical_officer');
        echo form_input(['name' => 'county_medical_officer', 'id' => 'county_medical_officer', 'pattern'=>'[a-zA-Z\s]+', 'value' => $details['county_medical_officer'] ,'class' => 'form-control', 'placeholder' => 'Enter Name of County Medical Officer']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('Mobile Phone Number of County Medical Officer','county_medical_officer_phone');
        echo form_error('county_medical_officer_phone');
        echo form_input(['name' => 'county_medical_officer_phone', 'id' => 'county_medical_officer_phone', 'pattern'=>"[07]{2}[0-9]{8}"  ,'value' => $details['county_medical_officer_phone'] ,'class' => 'form-control', 'placeholder' => 'e.g. 0712345678']);
        ?>
      </div>
	  
	  <div class="form-group">
        <?php
        echo form_label('Email Address of County Medical Officer','county_medical_officer');
        echo form_error('county_medical_officer_email');
        echo form_input(['name' => 'county_medical_officer_email', 'pattern'=>"[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$", 'id' => 'county_medical_officer_email',  'value' => $details['county_medical_officer_email'] ,'class' => 'form-control', 'placeholder' => 'e.g. someone@example.com']);
        ?>
      </div>
      <button class="btn btn-lg btn-danger btn-block" name="submit" type="submit">Submit</button>
      <?php 
      if (isset($update_id)){
          echo form_hidden('update_id', $update_id);
      }
      echo form_close();?>
    </div>
  </div>
