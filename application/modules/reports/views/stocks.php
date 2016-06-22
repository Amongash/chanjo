<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#stock_level" aria-controls="stock_level" role="tab" data-toggle="tab">Stock Levels</a></li>
    <!--<li role="presentation"><a href="#inventory" aria-controls="inventory" role="tab" data-toggle="tab">Inventory</a></li>-->
    <li role="presentation"><a href="#stock_coverage" aria-controls="stock_coverage" role="tab" data-toggle="tab">Coverage Infor</a></li>
    <li role="presentation"><a href="#stock_summary" aria-controls="stock_summary" role="tab" data-toggle="tab">Stock Transaction Summary</a></li>
    <li role="presentation"><a href="#stock_comparison" aria-controls="stock_comparison" role="tab" data-toggle="tab">Stock Coverage Comparison</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">


    <div role="tabpanel" class="tab-pane active" id="stock_level">


      <div class="form-inline row">
        <div  class="form-group col-md-2">

					<select id="levels" class="form-control col-md-2 ">
						<option value="NULL">- Select Level -</option>
						<?php
            foreach ($user_levels as $key => $value) {
              $name=$value['name'];
              $id=$value['id'];
              echo "<option value='$name' data-id='$id'>$name</option>";
            }

						?>
					</select>

        </div>

        <div id="" class="form-group col-md-2">

        <select id="regions" class="form-control col-md-2 ">
          <option value="NULL">- All Regions -</option>
          <?php
          foreach ($regions as $key => $value) {
            $name=$value['region_name'];
            $id=$value['id'];
            echo "<option value='$id'>$name</option>";
          }

          ?>
        </select>
        </div>

        <div id="" class="form-group col-md-2">

        <select id="counties" class="form-control col-md-2 ">
          <option value="NULL">- All Counties -</option>

        </select>
        </div>

        <div id="" class="form-group col-md-2">

        <select id="subcounties" class="form-control col-md-2 ">
          <option value="NULL">- All Sub-Counties -</option>

        </select>
        </div>


        <button type="submit" id="submit_stock_levels" class="btn btn-success col-md-1">Submit</button>
      </div>

      <div id="report_display" class="row jumbotron" style="min-height:400px;margin-top:2%;border-radius:0;padding-left:0">

      </div>


      </div>



    <div role="tabpanel" class="tab-pane" id="inventory">
      <div class="row">
          <div class="col-lg-12">

          <div class="row">
          <div class="col-lg-3">
            <div class="panel-body">
              <div class="input-group select2-bootstrap-prepend">
                <select class=" location">

                </select>
              </div>
            </div>
          </div>
          </div>

        </div>
      <div class="table-responsive">
       <?php echo $this->session->flashdata('msg');  ?>



      <table class="table table table-bordered table-hover table-striped" id="inventory">
              <thead>

                    <th>Vaccine/Diluents</th>
                    <th>Vaccine Formulation</th>
                    <th>Mode Of Administration</th>
                    <th>Action</th>
              </thead>

              <tbody>

                   <?php foreach ($vaccines as $vaccine) {
                    $ledger_url = base_url().'reports/ledger?vac='.$vaccine['id'].'';
                    ?>
                    <tr>
                          <td><?php echo $vaccine['vaccine_name']?></td>
                          <td><?php echo $vaccine['vaccine_formulation']?></td>
                          <td><?php echo $vaccine['mode_administration']?></td>
                          <td align="center"><a id="url" href="<?php echo $ledger_url ?>" class="btn btn-success btn-xs"> view vaccine ledger <i class="fa  fa-book"></i> </a></td>

                    </tr>
                     <?php }?>

              </tbody>
              </table>
      </div>



    </div>
  </div>



    <div role="tabpanel" class="tab-pane" id="stock_coverage">
      <div class="row" style="margin-bottom:1%;">
        <p class="bg-info col-md-3" style="padding:1%;">
				<span class="badge ">1</span>
		<strong>Select Antigents to compare.  </strong>

		</p>
    <p class="bg-info col-md-3" style="padding:1%;">
    <span class="badge ">2</span>
<strong>Select time interval.  </strong>

</p>
<p class="bg-info col-md-3" style="padding:1%;">
<span class="badge ">3</span>
<strong>Select Region/Station.  </strong>

</p>
      </div>
      <div class="row">

        <div id="" class="form-group col-md-2">

          <select id="vaccines" class="form-control  ">
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

					</select>


        </div>
        <div id="" class="form-group col-md-2">

          <select id="vaccines2" class="form-control  ">
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

					</select>




        </div>

        <div id="" class="form-group col-md-2">

          <input type="text" class="form-control" id="from" placeholder="from">


        </div>
        <div id="" class="form-group col-md-2">

          <input type="text" class="form-control" id="date_to" placeholder="to">


        </div>



      </div>

      <div class="form-inline row">
        <div  class="form-group col-md-2">

					<select id="levels_coverage" class="form-control  ">
						<option value="NULL">- Select Level -</option>
						<?php
            foreach ($user_levels as $key_coverage => $value) {
              $name=$value['name'];
              $id=$value['id'];
              echo "<option value='$name' data-id='$id'>$name</option>";
            }

						?>
					</select>

        </div>

        <div id="" class="form-group ">

        <select id="regions_coverage" class="form-control  ">
          <option value="NULL">- All Regions -</option>
          <?php
          foreach ($regions as $key_coverage => $value) {
            $name=$value['region_name'];
            $id=$value['id'];
            echo "<option value='$id'>$name</option>";
          }

          ?>
        </select>
        </div>

        <div id="" class="form-group ">

        <select id="counties_coverage" class="form-control  ">
          <option value="NULL">- All Counties -</option>

        </select>
        </div>

        <div id="" class="form-group ">

        <select id="subcounties_coverage" class="form-control  ">
          <option value="NULL">- All Sub-Counties -</option>

        </select>
        </div>


        <button type="submit" id="submit_coverage" class="btn btn-success ">Submit</button>
      </div>





      <div id="stock_coverage_display" class="row" style="min-height:400px;margin-top:2%;border-radius:0;padding-left:0;overflow: scroll;">

      </div>

    </div>


    <div role="tabpanel" class="tab-pane" id="stock_summary">

      <div class="row">
        <div id="" class="form-group col-md-2">

        <select id="vaccines_stock_summary" class="form-control col-md-2 ">
          <option value="NULL">- All Vaccines -</option>
          <?php
          foreach ($vaccines as $key => $value) {
            $name=$value['vaccine_name'];
            $id=$value['id'];
            echo "<option value='$id'>$name</option>";
          }

          ?>
        </select>
        </div>
        <div id="" class="form-group col-md-2">

          <input type="text" class="form-control" id="from_for_summary" placeholder="from">


        </div>
        <div id="" class="form-group col-md-2">

          <input type="text" class="form-control" id="to_for_summary" placeholder="to">


        </div>
      </div>

      <div class="form-inline row">
        <div  class="form-group col-md-2">

					<select id="levels_stock_summary" class="form-control col-md-2 ">
						<option value="NULL">- Select Level -</option>
						<?php
            foreach ($user_levels as $key_stock_summary => $value) {
              $name=$value['name'];
              $id=$value['id'];
              echo "<option value='$name' data-id='$id'>$name</option>";
            }

						?>
					</select>

        </div>

        <div id="" class="form-group col-md-2">

        <select id="regions_stock_summary" class="form-control col-md-2 ">
          <option value="NULL">- All Regions -</option>
          <?php
          foreach ($regions as $key_stock_summary => $value) {
            $name=$value['region_name'];
            $id=$value['id'];
            echo "<option value='$id'>$name</option>";
          }

          ?>
        </select>
        </div>

        <div id="" class="form-group col-md-2">

        <select id="counties_stock_summary" class="form-control col-md-2 ">
          <option value="NULL">- All Counties -</option>

        </select>
        </div>

        <div id="" class="form-group col-md-2">

        <select id="subcounties_stock_summary" class="form-control col-md-2 ">
          <option value="NULL">- All Sub-Counties -</option>

        </select>
        </div>


        <button type="submit" id="submit_stock_summary" class="btn btn-success col-md-1">Submit</button>
      </div>


      <div id="stock_summary_display" class="row" style="min-height:400px;margin-top:2%;border-radius:0">



      </div>

    </div>


</div>

<script type="text/javascript">

    $(document).ready(function() {
      $('#regions,#regions_coverage,#counties,#counties_coverage,#subcounties,#subcounties_coverage').hide();
      $('#regions_stock_summary,#counties_stock_summary,#subcounties_stock_summary').hide();
      $( "#from,#from_for_summary" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      dateFormat: 'dd-mm-yy',
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#date_to,#to_for_summary" ).datepicker( "option", " minDate", selectedDate );
      }
    });
    $( "#date_to,#to_for_summary" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      dateFormat: 'dd-mm-yy',
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from,#from_for_summary" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

      $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })

      var $a = $('a[id="url"]');
      //store the original value so that we can handler multiple changes
      $a.data('href', $a.attr('href'))
      $(".location").change(function () {
          $a.attr('href', $a.data('href') + '&name=' + this.value)
      });

      window.setTimeout(function() {
         $("#alert-message").fadeTo(500, 0).slideUp(500, function(){
             $(this).remove();
         });
     }, 2000);


$(".location").select2({
    allowClear: false,
    placeholder: "Select a location",
    ajax: {
        url: "<?php echo base_url('reports/get_location') ?>",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            term: params.term // search term
          };
        },
        processResults: function (data) {

          return {
              results: $.map(data, function(obj) {
                  return { id: obj.location, text: obj.location };
              })
          };
        }
    }
});

var url="<?php echo base_url(); ?>";
function ajax_fill_data(function_url,div){
    var function_url =url+function_url;
    var loading_icon=url+"assets/images/loader.gif";
    $.ajax({
    type: "POST",
    url: function_url,
    beforeSend: function() {
    $(div).html("<img style='margin:20% 50% 0 50%;' src="+loading_icon+">");
    },
    success: function(msg) {
    $(div).html(msg);
    }
    });
    }

    $( "#submit_stock_levels" ).click(function() {

      var level=$('option:selected', '#levels').attr('data-id');
      var region_name=$('option:selected', '#regions').text();
      var region_id=$('option:selected', '#regions').val();
      var county=$('#counties').val();
      var subcounty=$('#subcounties').val();
      console.log(region_id);

      ajax_fill_data('reports/stock_levels/'+level+'/'+region_name+'/'+region_id+'/'+county,"#report_display");

    });

    $( "#submit_coverage" ).click(function() {

      var level=$('option:selected', '#levels_coverage').attr('data-id');
      var region=$('#regions_coverage').val();
      var county=$('#counties_coverage').val();
      var subcounty=$('#subcounties_coverage').val();
      var vaccines=$('#vaccines').val();
      var vaccines2=$('#vaccines2').val();
      var maxdate=$('#date_to').val()
      var mindate=$('#from').val()
      console.log(maxdate);

     ajax_fill_data('reports/coverage/'+level+'/'+region+'/'+county+'/'+vaccines+'/'+vaccines2+'/'+maxdate+'/'+mindate,"#stock_coverage_display");

    });

    $( "#submit_stock_summary" ).click(function() {

      var level=$('option:selected', '#levels_stock_summary').attr('data-id');
      var region=$('#regions_stock_summary').val();
      var county=$('#counties_stock_summary').val();
      var subcounty=$('#subcounties_stock_summary').val();
      var vaccines=$('#vaccines_stock_summary').val();

     ajax_fill_data('reports/stock_summary/'+level+'/'+region+'/'+county,"#stock_summary_display");

    });



    $('#levels,#levels_coverage,#levels_stock_summary').on('change', function(){
      $('#regions,#regions_coverage,#regions_stock_summary,#counties,#counties_coverage,#counties_stock_summary,#subcounties,#subcounties_coverage,#subcounties_stock_summary').val('NULL');

      if ($(this).val()==='Region') {

        $('#regions,#regions_coverage,#regions_stock_summary').show();
        $('#counties,#counties_coverage,#counties_stock_summary,#subcounties,#subcounties_coverage,#subcounties_stock_summary').hide();
      }else if ($(this).val()==='County') {

        $('#counties,#counties_coverage,#counties_stock_summary').show();
        $('#regions,#regions_coverage,#regions_stock_summary,#subcounties,#subcounties_coverage,#subcounties_stock_summary').hide();
        var drop_down='';
        var county_select = "<?php echo base_url(); ?>reports/getallCountiesjson/";
    $.getJSON( county_select ,function( json ) {
     $("#counties,#counties_coverage,#counties_stock_summary").html('<option value="NULL" selected="selected">All Counties</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["county_name"]+"</option>";
      });
      $("#counties,#counties_coverage,#counties_stock_summary").append(drop_down);
    });


      }else if ($(this).val()==='Sub County') {

        $('#subcounties,#subcounties_coverage,#subcounties_stock_summary').show();
        $('#regions,#regions_coverage,#regions_stock_summary,#counties,#counties_coverage,#counties_stock_summary').hide();

        var drop_down='';
        var subcounty_select = "<?php echo base_url(); ?>reports/getallSubcountiesjson/";
    $.getJSON( subcounty_select ,function( json ) {
     $("#subcounties,#subcounties_coverage,#subcounties_stock_summary").html('<option value="NULL" selected="selected">All Sub-Counties</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["subcounty_name"]+"</option>";
      });
      $("#subcounties,#subcounties_coverage,#subcounties_stock_summary").append(drop_down);
    });

      }else if ($(this).val()==='National') {

        $('#regions,#regions_coverage,#regions_stock_summary,#counties,#counties_coverage,#counties_stock_summary,#subcounties,#subcounties_coverage,#subcounties_stock_summary').hide();

      }

        });

    $('#regions,#regions_coverage,#regions_stock_summary').on('change', function(){
      $('#counties,#counties_coverage,#counties_stock_summary,#subcounties,#subcounties_coverage,#subcounties_stock_summary').val('NULL');
     		var region_val=$(this).val();
        $('#counties,#counties_coverage,#counties_stock_summary').show();
        var drop_down='';
	      var county_select = "<?php echo base_url(); ?>reports/getCountiesjson/"+region_val;
  	$.getJSON( county_select ,function( json ) {
     $("#counties,#counties_coverage,#counties_stock_summary").html('<option value="NULL" selected="selected">All Counties</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["county_name"]+"</option>";
      });
      $("#counties,#counties_coverage,#counties_stock_summary").append(drop_down);
    });


    });

    $('#counties,#counties_coverage,#counties_stock_summary').on('change', function(){
      $('#subcounties,#subcounties_coverage,#subcounties_stock_summary').val('NULL');
     		var county_val=$(this).val();
        $('#subcounties,#subcounties_coverage,#subcounties_stock_summary').show();
        //console.log(county_val);
        var drop_down='';
	      var subcounty_select = "<?php echo base_url(); ?>reports/getSubcountiesjson/"+county_val;
  	$.getJSON( subcounty_select ,function( json ) {
     $("#subcounties,#subcounties_coverage,#subcounties_stock_summary").html('<option value="NULL" selected="selected">All Sub-counties</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["subcounty_name"]+"</option>";
      });
      $("#subcounties,#subcounties_coverage,#subcounties_stock_summary").append(drop_down);
    });


    });

      });

</script>
