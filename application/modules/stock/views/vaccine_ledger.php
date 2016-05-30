<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
        <table id="table" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Station</th>
                    <th>Quantity</th>
                    <th>Batch</th>
                    <th>Expiry</th>
                    <th>Stock Balance</th>
                </tr>
            </thead>
        </table>
            
        </div>

        <script type="text/javascript">

            var url = "<?php echo base_url('stock/stock_data/'.$id) ?>";
            var editor; // use a global for the submit and return data rendering in the examples
             
            $(document).ready(function() {
                editor = new $.fn.dataTable.Editor( {
                    ajax: url,
                    table: "#table",
                    fields: [ {
                            label: "Date:",
                            name: "transaction_date"
                        }, {
                            label: "Type:",
                            name: "type"
                        }, {
                            label: "Station:",
                            name: "to_from"
                        }, {
                            label: "Quantity:",
                            name: "quantity"
                        }, {
                            label: "Batch:",
                            name: "batch"
                        }, {
                            label: "Expiry:",
                            name: "expiry",
                            type: "datetime"
                        }, {
                            label: "Stock Balance:",
                            name: "balance"
                        }
                    ]
                } );
             
                // Activate the bubble editor on click of a table cell
                $('#table').on( 'click', 'tbody td:not(:first-child)', function (e) {
                    editor.bubble( this );
                } );
             
                $('#table').DataTable( {
                    dom: "Bfrtip",
                    scrollY: 300,
                    paging: false,
                    ajax: url,
                    columns: [
                        {
                            data: null,
                            defaultContent: '',
                            className: 'select-checkbox',
                            orderable: false
                        },
                        { data: "transaction_date" },
                        { data: "type" },
                        { data: "to_from" },
                        { data: "quantity" },
                        { data: "batch" },
                        { data: "expiry" },
                        { data: "balance", render: $.fn.dataTable.render.number( ',', '.', 0 ) }
                    ],
                    order: [ 1, 'asc' ],
                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                    buttons: [
                        { extend: "edit", editor: editor }
                    ]
                } );
            } );

    </script>
