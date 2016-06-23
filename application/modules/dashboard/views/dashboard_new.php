<style>
.custom-select{
  width:20%  !important;
  height:40px !important;
  font-size: 1.2em !important;
  font-weight: bolder;
  margin-left: 2.6%;
}
#filter_all{
  height:40px !important;
  margin-left: 2.6%;
  border-radius: 0 !important;
}
#actions{
  margin-left: 2.6%;
  border-radius: 0 !important;
}
.modal-body{
  font-size: 1.2em !important;
}

</style>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($user_level != '5') { ?>
<?php }else {?>
  <div>

  </div>
<?php } ?>


  <div class="form-inline row">

    <select id="vaccines" name="vaccines" class="form-control custom-select  ">
      <option value="NULL">- Select Vaccine -</option>
      <option value="bcg">BCG </option>
      <option value="opv">OPV 0 </option>
      <option value="opv1">OPV 1 </option>
      <option value="opv2">OPV 2 </option>
      <option value="opv3">OPV 3 </option>
      <option value="dpt1">DPT 1 </option>
      <option value="dpt2">DPT 2 </option>
      <option value="dpt3">DPT 3 </option>
      <option value="pcv1">PCV 1 </option>
      <option value="pcv2">PCV 2 </option>
      <option value="pcv3">PCV 3 </option>
      <option value="`measles 1`">Measles 1</option>
      <option value="`measles 2`">Measles 2 </option>
      <option value="`measles 3`">Measles 3 </option>
      <option value="rota1">Rota 1  </option>
      <option value="rota2">Rota 2 </option>

    </select>

    <select id="levels" class=" form-control custom-select" >
      <option value="NULL">- Select Level -</option>
      <?php
      foreach ($user_levels as $key => $value) {
        $name=$value['name'];
        $id=$value['id'];
        echo "<option value='$name' data-id='$id'>$name</option>";
      }

      ?>
    </select>

    <select id="regions" class=" form-control custom-select">
      <option value="NULL">- Select Region -</option>
      <?php
      foreach ($regions as $key => $value) {
        $name=$value['region_name'];
        $id=$value['id'];
        echo "<option value='$id'>$name</option>";
      }

      ?>
    </select>
    <select id="counties" class=" form-control custom-select">
      <option value="NULL">- Select County -</option>

    </select>
    <select id="subcounties" class=" form-control custom-select">
      <option value="NULL">- Select Sub-County -</option>

    </select>
    <select id="facilities" class=" form-control custom-select">
      <option value="NULL">- Select Facility -</option>

    </select>

    <button type="submit" id="filter_all" name="filter_all" class="btn btn-success btn-lg">Filter</button>





  </div>


<div class="row" style="min-height:300px">
    <div class="block-web">
        <!--<div class="col-lg-6">

            <h5 class="content-header text-info">Coverage</h5>
            </br>
            <div id="coverage" name="coverage"></div>


        </div>-->

        <div class="col-lg-12">

            <h5 class="content-header text-info">Cumulative Coverage</h5>
            </br>
            <button type="button" id="actions" name="actions" data-toggle="modal" data-target="#myModal" class="btn btn-info btn-sm pull-left">Recommendations</button>
            <div id="coverage_cumulative" name="coverage_cumulative"></div>


        </div>
    </div>
</div>

<br/>


<div class="row" style="min-height:300px">
    <div class="block-web">
        <div class="col-lg-12">

            <div class="col-md-6">
                <h5 class="content-header text-info">Stock Available</h5>

                <div id="stocks" name="stocks"></div>
            </div>
            <div class="col-md-6">

                <h5 class="content-header text-info">Months of Stock</h5>

                <div id="mos" name="mos"></div>
            </div>

        </div>
    </div>
</div>


<br/>




<div class="row" style="min-height:300px">
    <div class="block-web">
        <div class="col-lg-12">

            <div class="col-md-6">
                <h5 class="content-header text-info">+ve Cold Chain</h5>

                <div id="positive" name="positive"></div>
            </div>
            <?php if ($user_level!=5) {
              # code...
            ?>
            <div class="col-md-6">

                <h5 class="content-header text-info">-ve Cold Chain</h5>

                <div id="negative" name="negative"></div>
            </div>

            <?php } ?>

        </div>
    </div>
</div>


<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Recommendations</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="margin-bottom:1%;">

          <p class="bg-info col-md-12" style="padding:1%;">
          <span class="badge ">Ideal</span>
      If the <b>antigen line</b> (blue) appears <strong>close and above</strong> cummulative target polulation (red) please adjust...

      </p>
          <p class="bg-warning col-md-12" style="padding:1%;">
  				<span class="badge">Incorrect</span>
  		If the <b>antigen line</b> (blue) appears <strong>above</strong> cummulative target polulation (red) please adjust...

  		</p>
      <p class="bg-danger col-md-12" style="padding:1%;">
      <span class="badge">Incorrect</span>
  If the <b>antigen line</b> (blue) appears <strong>below</strong> cummulative target polulation (red) please adjust...

  </p>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">

var url="<?php echo base_url(); ?>";
$('#myModal').on('shown.bs.modal', function () {
})

    ajax_fill_data('dashboard/vaccineBalance/NULL',"#stocks");
    ajax_fill_data('dashboard/vaccineBalancemos/NULL/NULL',"#mos");
    ajax_fill_data('dashboard/positiveColdchain/NULL/NULL',"#positive");
    ajax_fill_data('dashboard/negativeColdchain',"#negative");
    ajax_fill_data('dashboard/coverage/NULL',"#coverage");
    ajax_fill_data('dashboard/cumulative_coverage/NULL/NULL/NULL',"#coverage_cumulative");

    $('#regions,#counties,#subcounties,#facilities').hide();

    $('#levels').on('change', function(){
      $('#regions,#counties,#subcounties,#facilities').val('NULL');

      if ($(this).val()==='Region') {

        $('#regions').show();
        $('#counties,#subcounties,#facilities').hide();
      }else if ($(this).val()==='County') {

        $('#counties').show();
        $('#regions,#subcounties,#facilities').hide();
        var drop_down='';
        var county_select = "<?php echo base_url(); ?>reports/getallCountiesjson/";
    $.getJSON( county_select ,function( json ) {
     $("#counties").html('<option value="NULL" selected="selected">Select Counties</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["county_name"]+"</option>";
      });
      $("#counties").append(drop_down);
    });


      }else if ($(this).val()==='Sub County') {

        $('#subcounties').show();
        $('#regions,#counties,#facilities').hide();

        var drop_down='';
        var subcounty_select = "<?php echo base_url(); ?>reports/getallSubcountiesjson/";
    $.getJSON( subcounty_select ,function( json ) {
     $("#subcounties").html('<option value="NULL" selected="selected">Select Sub-Counties</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["subcounty_name"]+"</option>";
      });
      $("#subcounties").append(drop_down);
    });

  }else if ($(this).val()==='Facility') {

        $('#facilities').show();
        $('#regions,#counties,#subcounties').hide();

        var drop_down='';
        var facility_select = "<?php echo base_url(); ?>reports/getallFacilitiesjson/";
    $.getJSON( facility_select ,function( json ) {
     $("#facilities").html('<option value="NULL" selected="selected">Select Facility</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["facility_name"]+"</option>";
      });
      $("#facilities").append(drop_down);
    });

      }
      else if ($(this).val()==='National') {

        $('#regions,#counties,#subcounties,#facilities').hide();

      }

        });


    $( "#filter_all" ).click(function() {

      var level=$('option:selected', '#levels').attr('data-id');
      var region_name=$('option:selected', '#regions').text();
      var region_id=$('option:selected', '#regions').val();
      var county=$('#counties').val();
      var subcounty=$('#subcounties').val();
      var facility=$('#facilities').val();
      if ($('option:selected', '#levels').val()==='NULL'||$('option:selected', '#levels').val()==='National') {
        var station='KENYA';
      }
       if ($('option:selected', '#regions').val()!='NULL') {
        var station=$('option:selected', '#regions').text();
      }
      if ($('option:selected', '#counties').val()!='NULL') {
       var station=$('option:selected', '#counties').text();
     }
     if ($('option:selected', '#subcounties').val()!='NULL') {
      var station=$('option:selected', '#subcounties').text();
    }
    if ($('option:selected', '#facilities').val()!='NULL') {
     var station=$('option:selected', '#facilities').text();
   }
    console.log(station);
    var vaccine=$('option:selected', '#vaccines').val();


      //ajax_fill_data('dashboard/vaccineBalance/'+name,"#stocks");
      //ajax_fill_data('dashboard/vaccineBalancemos/'+name+'/'+population,"#mos");
      ajax_fill_data('dashboard/cumulative_coverage/'+level+'/'+station+'/'+vaccine+'/'+region_id+'/'+county+'/'+subcounty+'/'+facility,"#coverage_cumulative");
      ajax_fill_data('dashboard/coverage/NULL',"#coverage");
      //ajax_fill_data('dashboard/negativeColdchain/'+a+'/'+name,"#negative");
      //ajax_fill_data('dashboard/positiveColdchain/'+a+'/'+name,"#positive");


    });

    function ajax_fill_data(function_url,div){
        var function_url =url+function_url;
        var loading_icon=url+"assets/images/loader.gif";
        $.ajax({
        type: "POST",
        url: function_url,
        beforeSend: function() {
        $(div).html("<img style='margin:10% 50% 0 50%;' src="+loading_icon+">");
        },
        success: function(msg) {
        $(div).html(msg);
        }
        });
        }




</script>
