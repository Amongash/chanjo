<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php echo form_open('facility/submit',array('class'=>'form-horizontal', 'id' =>'facility'));

$regions = array();
$regions[] = "--Select Region--";
foreach ($region as $row) {
    $regions[$row->id] = $row->region_name;

$county = array('--Select County--');    
$subcounty = array('--Select Sub County--');    
}
 //echo validation_errors('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>',' </b></div>');
      ?>
 <div class="row">
      <div class="col-lg-4 col-lg-offset-4">

             
        <style type="text/css">
        .hidden>div {
            display:none;
        }

        .visible>div {
            display:block;
        }
        </style>
        <div class="form-group">
          <?php
          echo form_label('Facility Name','facility_name');
          echo form_error('facility_name');
          echo form_input(['name' => 'facility_name', 'id' => 'facility_name',  'value' =>  $facility['facility_name'],'class' => 'form-control', 'readonly'=>'true']);
          ?>
        </div>

        <div class="form-group">
        <button class="btn btn-primary btn-lg btn-block bs" type="button" id="location">Update Location</button>
        </div>
      <div class="text_container hidden">

        <div class="form-group">
          <?php
          echo form_label('Region','region_name');
          echo form_error('region_name');
          echo form_dropdown('region_name', $regions, set_value($facility['region_name']), 'id="region_name" class="form-control"');
          ?>
        </div>
        
        <div class="form-group">
          <?php
          echo form_label('County','county_name');
          echo form_error('county_name');
          echo form_dropdown('county_name', $county, set_value($facility['county_name']), 'id="county_name" class="form-control"');
          ?>
        </div>
        
        <div class="form-group">
          <?php
          echo form_label('Sub-county','subcounty_name');
          echo form_error('subcounty_name');
          echo form_dropdown('subcounty_name', $subcounty, set_value($facility['subcounty_name']), 'id="subcounty_name" class="form-control"');
          ?>
        </div>
      </div>
        
        <div class="form-group">
          <?php
          echo form_label('Name of Officer In-charge','incharge');
          echo form_error('officer_incharge');
          echo form_input(['name' => 'officer_incharge','pattern'=>'[a-zA-Z\s]+', 'id' => 'officer_incharge',  'value' => $details['officer_incharge'] , 'class'=> 'form-control']);
          ?>
        </div>

        <div class="form-group">
          <?php
          echo form_label('Email Address','email');
          echo form_error('email');
          echo form_input(['name' => 'email', 'id' => 'email', 'pattern'=>"[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$", 'value' => $details['email'], 'placeholder'=>'e.g. someone@example.com', 'class'=> 'form-control']);
          ?>
        </div>

        <div class="form-group">
          <?php
          echo form_label('Phone Number','phone');
          echo form_error('phone');
          echo form_input(['name' => 'phone', 'pattern'=>"[07]{2}[0-9]{8}",'id' => 'phone',  'value' => $details['phone'], 'class'=> 'form-control','placeholder' => 'e.g. 0712345678']);
          ?>
        </div>
        
        <div class="form-group">
          <?php
          echo form_label('Number of staff','staff');
          echo form_error('staff');
          echo form_input(['name' => 'staff','type'=>'number' ,'min'=>'0', 'id' => 'staff', 'value' =>  $details['staff'], 'class' => 'form-control', 'placeholder' => 'Staff involved in immunization']);
          ?>
        </div>
        
        <div class="form-group">
          <?php
          echo form_label('Nearest Town','nearest_town');
          echo form_error('nearest_town');
          echo form_input(['name' => 'nearest_town','type'=>'number', 'min'=>'0','step'=>'0.1', 'id' => 'nearest_town',  'value' =>  $details['nearest_town'], 'class' => 'form-control']);
          ?>
          </div>
          
        <div class="form-group">
          <?php
          echo form_label('Distance to Nearest Town','nearest_town_distance');
          echo form_error('nearest_town_distance');
          echo form_input(['name' => 'nearest_town_distance','type'=>'number', 'min'=>'0','step'=>'0.1', 'id' => 'nearest_town_distance', 'placeholder' =>'In Km', 'value' =>  $details['nearest_town_distance'], 'class' => 'form-control']);
          ?>
        </div>
        
        <div class="form-group">
          <?php
          echo form_label('Distance to Sub-county depot','nearest_depot_distance');
          echo form_error('nearest_depot_distance');
          echo form_input(['name' => 'nearest_depot_distance','type'=>'number', 'min'=>'0','step'=>'0.1', 'id' => 'nearest_depot_distance', 'placeholder' =>'In Km', 'value' =>  $details['nearest_depot_distance'], 'class' => 'form-control']);
          ?>
        </div>

        <div class="form-group">
          <?php
          echo form_label('WCBA Population (15-49)','wcba_population');
          echo form_error('wcba_population');
          echo form_input(['name' => 'wcba_population', 'type'=>'number', 'min'=>'0','id' => 'wcba_population',  'value' =>  $facility['women_population'], 'class' => 'form-control']);
          ?>
        </div>  
        
        <div class="form-group">
          <?php
          echo form_label('Total Catchment Population','catchment_population');
          echo form_error('catchment_population');
          echo form_input(['name' => 'catchment_population','type'=>'number', 'min'=>'0', 'id' => 'catchment_population',  'value' => $facility['total_population'], 'class' => 'form-control']);
          ?>
        </div>  
          
        <div class="form-group">
          <?php
          echo form_label('Catchment Population (Under 1 yr)','catchment_population_under_one');
          echo form_error('catchment_population_under_one');
          echo form_input(['name' => 'catchment_population_under_one','type'=>'number', 'min'=>'0', 'id' => 'catchment_population_under_one',  'value' => $facility['under_one_population'], 'class' => 'form-control']);
          ?>
        </div>
        
         <div class="form-group">
          <?php   
          echo form_label('Number of Cold Boxes','cold_box');
          echo form_error('cold_box');      
          echo form_input(['name' =>'cold_box','type'=>'number', 'min'=>'0' ,'value' => $details['cold_box'], 'id' => 'cold_box', 'class' =>'form-control']);
          ?>
        </div>      

        <div class="form-group">
          <?php   
          echo form_label('Number of Vaccine Carriers','vaccine_carrier');
          echo form_error('vaccine_carrier');     
          echo form_input(['name' =>'vaccine_carrier', 'type'=>'number', 'min'=>'0', 'value' => $details['vaccine_carrier'], 'id' => 'vaccine_carrier', 'class' =>'form-control']);
          ?>
        </div>
        
        
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-6">
          <?php echo form_submit('submit', 'Submit', 'class="btn btn-lg btn-danger pull-right " id="submit"');
                     if (isset($update_id)){
                        echo form_hidden('update_id', $update_id);
                      }
                      echo form_close();?>
          </div>
        </div>
      </div>
    </div>
  </div> 
</div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
      $('.text_container').addClass("hidden");

      $('#location').click(function() {
        var container = $('.text_container');
        if (container.hasClass("hidden")) {
         container.removeClass("hidden").addClass("visible");
        } else {
          container.removeClass("visible").addClass("hidden");
        }
      });
    });
  </script>

<script type="text/javascript">
$(document).ready(function () {
        $("#region_name").change(function () {
            var regional = $(this).val();
            console.log(regional);
            var request = $.ajax({
                url: "<?php echo base_url(); ?>users/getCountyByRegion/" + regional,
                data: regional,
                type: "POST",
            });
            request.done(function (data) {
                data = JSON.parse(data);
                console.log(data);
                $("#county_name option").remove();
                $('#county_name').append("<option value=''>--Select County--</option> ");
                $.each(data, function (key, value) {
                    $('#county_name').append("<option value='" + value.county_id + "'>" + value.county_name + "</option>");
                });
            });
            request.fail(function (jqXHR, textStatus) {
            });
        });
    });

    $(document).ready(function () {
        $("#county_name").change(function () {
            var county = $(this).val();
            console.log(county);
            var request = $.ajax({
                url: "<?php echo base_url(); ?>users/getSubcountyByCounty/" + county,
                data: county,
                type: "POST",
            });
            request.done(function (data) {
                data = JSON.parse(data);
                console.log(data);
                $("#subcounty_name option").remove();
                $('#subcounty_name').append("<option value=''>--Select Sub County--</option> ");
                $.each(data, function (key, value) {
                    $('#subcounty_name').append("<option value='" + value.subcounty_id + "'>" + value.subcounty_name + "</option>");
                });
            });
            request.fail(function (jqXHR, textStatus) {
            });
        });
    });


</script>

