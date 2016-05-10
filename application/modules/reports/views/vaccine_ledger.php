<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
    <div class="col-sm-3 col-sm-6">
            <div class="information green_info">
                <div class="information_inner">
                    <div class="info green_symbols"><i class="fa fa-cubes icon"></i></div>
                    <span> </span>
                    <h1 class="bolded" id="bal"><?php echo ($vaccine[0]["vaccine_name"]);?></h1>

                </div>
            </div>
        </div>
    </div>
 <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <div class="well well-sm"><b>Stocks Ledger</b></div>

<div class="row">
<div class="col-lg-12" style="margin-top: 10px;">
 
        <div class="table-responsive">
            <table id="table" class="table table-bordered table-hover table-striped" cellspacing="0" width="100%">
                <thead>

                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Station</th>
                    <th>Quantity</th>
                    <th>Batch</th>
                    <th>Expiry</th>
                    <th>Stock Balance</th>
                  
                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Station</th>
                    <th>Quantity</th>
                    <th>Batch</th>
                    <th>Expiry</th>
                    <th>Stock Balance</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <script type="text/javascript">

            var save_method; //for save method string
            var table;
            var url = "<?php echo base_url('reports/stock_data/'.$id.'/'.$station);?>";

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

    </script>
