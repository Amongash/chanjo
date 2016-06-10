<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#stock_level" aria-controls="stock_level" role="tab" data-toggle="tab">Stock Levels</a></li>
    <li role="presentation"><a href="#inventory" aria-controls="inventory" role="tab" data-toggle="tab">Inventory</a></li>
    <li role="presentation"><a href="#stock_coverage" aria-controls="stock_coverage" role="tab" data-toggle="tab">Stock Coverage</a></li>
    <li role="presentation"><a href="#stock_summary" aria-controls="stock_summary" role="tab" data-toggle="tab">Stock Transaction Summary</a></li>
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

      <div id="report_display" class="row jumbotron" style="min-height:400px;margin-top:2%;border-radius:0">

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

      <div id="stock_coverage_display" class="row jumbotron" style="min-height:400px;margin-top:2%;border-radius:0">

      </div>

    </div>
    <div role="tabpanel" class="tab-pane" id="stock_summary">


      <div id="stock_summary_display" class="row jumbotron" style="min-height:400px;margin-top:2%;border-radius:0">

      </div>

    </div>


</div>

<script type="text/javascript">

    $(document).ready(function() {
      $('#regions,#counties,#subcounties').hide();

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
      var region=$('#regions').val();
      var county=$('#counties').val();
      var subcounty=$('#subcounties').val();
      console.log(level);


      ajax_fill_data('reports/stock_levels/'+level+'/'+region+'/'+county,"#report_display");


    });

    $('#levels').on('change', function(){

      if ($(this).val()==='Region') {

        $('#regions').show();
        $('#counties,#subcounties').hide();
      }else if ($(this).val()==='County') {

        $('#counties').show();
        $('#regions,#subcounties').hide();
        var drop_down='';
        var county_select = "<?php echo base_url(); ?>reports/getallCountiesjson/";
    $.getJSON( county_select ,function( json ) {
     $("#counties").html('<option value="NULL" selected="selected">All Counties</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["county_name"]+"</option>";
      });
      $("#counties").append(drop_down);
    });


      }else if ($(this).val()==='Sub County') {

        $('#subcounties').show();
        $('#regions,#counties').hide();

        var drop_down='';
        var subcounty_select = "<?php echo base_url(); ?>reports/getallSubcountiesjson/";
    $.getJSON( subcounty_select ,function( json ) {
     $("#subcounties").html('<option value="NULL" selected="selected">All Sub-Counties</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["subcounty_name"]+"</option>";
      });
      $("#subcounties").append(drop_down);
    });

      }else if ($(this).val()==='National') {

        $('#regions,#counties,#subcounties').hide();

      }

        });

    $('#regions').on('change', function(){
     		var region_val=$(this).val();
        $('#counties').show();
        var drop_down='';
	      var county_select = "<?php echo base_url(); ?>reports/getCountiesjson/"+region_val;
  	$.getJSON( county_select ,function( json ) {
     $("#counties").html('<option value="NULL" selected="selected">All Counties</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["county_name"]+"</option>";
      });
      $("#counties").append(drop_down);
    });


    });

    $('#counties').on('change', function(){
     		var county_val=$(this).val();
        $('#subcounties').show();
        //console.log(county_val);
        var drop_down='';
	      var subcounty_select = "<?php echo base_url(); ?>reports/getSubcountiesjson/"+county_val;
  	$.getJSON( subcounty_select ,function( json ) {
     $("#subcounties").html('<option value="NULL" selected="selected">All Sub-counties</option>');
      $.each(json, function( key, val ) {
        drop_down +="<option value='"+json[key]["id"]+"'>"+json[key]["subcounty_name"]+"</option>";
      });
      $("#subcounties").append(drop_down);
    });


    });

      });

</script>
