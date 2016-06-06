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
        <div class="form-group col-md-2">

          <select class="form-control">
            <option>Select Level</option>
            <option>National</option>
            <option>Regional</option>

        </select>
        </div>
        <div class="form-group col-md-2">

          <select class="form-control">
            <option>Select Vaccine</option>
            <option>Measles</option>
            <option>BCG</option>
          </select>
        </div>

        <div class="form-group col-md-2">

          <select class="form-control">
            <option>Select Stock Units</option>
            <option>MOS</option>
            <option>Totals</option>
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

      ajax_fill_data('reports/stock_levels',"#report_display");


    });


    });

</script>
