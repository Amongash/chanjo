<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">

<div class="col-lg-12" style="margin-top: 10px;">

  <style type="text/css">
    .select2-container--default .select2-selection--single {
    border-radius:0 0.25rem 0.25rem 0;
    min-height:1.85rem;
}
</style>
 <!--
<div class="row">
    <div class="col-lg-3">
      <div class="panel-body">
        <b>Region</b>
        <br>
        <div class="input-group select2-bootstrap-prepend">
          <span class="input-group-addon">
                            <input type="checkbox" checked>
                        </span>
          <select class=" region">

          </select>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="panel-body">
        <b>County</b>
        <br>
        <div class="input-group select2-bootstrap-prepend">
          <span class="input-group-addon">
                            <input type="checkbox" >
                        </span>
          <select class="county">
          </select>
        </div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="panel-body">
        <b>Sub-county</b>
        <br>
        <div class="input-group select2-bootstrap-prepend">
          <span class="input-group-addon">
                            <input type="checkbox">
                        </span>
          <select class="subcounty">
          </select>
        </div>
      </div>
    </div>

  </div>
-->
<div class="col-lg-12" style="margin-top: 10px;">
 
        <div class="table-responsive">
            <table id="table" class="table table-bordered table-hover table-striped" cellspacing="0" width="100%">
                <thead>

                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Vaccine</th>
                    <th>Batch</th>

                    <th>Quantity</th>
                    <th>Stock Balance</th>
                  
                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                     <th>Date</th>
                    <th>Type</th>
                    <th>Vaccine</th>
                    <th>Batch</th>

                    <th>Quantity</th>
                    <th>Stock Balance</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <script type="text/javascript">

            var save_method; //for save method string
            var table;
            var url = "<?php echo base_url('reports/stock_data') ?>";

            $(document).ready(function () {
                table = $('#table').DataTable({
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": url,
                        "type": "POST"
                    },

                    "responsive": {
                        "details": {
                            "type": 'column'
                        }
                    },
                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [-1], //last column
                            "orderable": false, //set not orderable
                        },
                    ],

                });
            });


            

            function reload_table() {
                table.ajax.reload(null, false); //reload datatable ajax
            }


        window.setTimeout(function () {
            $("#alert-message").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 5000);
    </script>

    <script type="text/javascript">


    $(document).ready(function() {

        $(".region").select2({
            allowClear: false,
            placeholder: "Select a region",
            ajax: {
                url: "<?php echo base_url('reports/getRegion') ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  return {
                    term: params.term // search term
                  };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                           return {
                                text: item.region_name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        $(".county").select2({
            allowClear: true,
            placeholder: "Select a county",
            ajax: {
                url: "<?php echo base_url('reports/getRegion') ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  return {
                    term: params.term // search term
                  };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                           return {
                                text: item.region_name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        $(".subcounty").select2({
            allowClear: true,
            placeholder: "Select a subcounty",
            ajax: {
                url: "<?php echo base_url('reports/getRegion') ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  return {
                    term: params.term // search term
                  };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                           return {
                                text: item.region_name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        $( ":checkbox" ).on( "click", function() {
                $( this ).parent().nextAll( "select" ).prop( "disabled", !this.checked );
        });


    });
    </script>