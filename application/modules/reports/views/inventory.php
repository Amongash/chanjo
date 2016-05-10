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

        <script type="text/javascript">
         // $(document).on('change', '.location', function () {
         //    var select = $(this);
      
         //    var location = select.val();
            
            var $a = $('a[id="url"]');
            //store the original value so that we can handler multiple changes
            $a.data('href', $a.attr('href'))
            $(".location").change(function () {
                $a.attr('href', $a.data('href') + '&name=' + this.value)
            });
        // });



        </script> 

        <script type="text/javascript">

               window.setTimeout(function() {
                  $("#alert-message").fadeTo(500, 0).slideUp(500, function(){
                      $(this).remove(); 
                  });
              }, 2000);
        </script> 

        <script type="text/javascript">


    $(document).ready(function() {

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
    });
    </script>