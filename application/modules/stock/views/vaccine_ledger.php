<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-3 col-sm-6">
        <div class="information green_info">
            <div class="information_inner">
                <div class="info green_symbols"><i class="fa fa-cubes icon"></i>
                </div>
                <span> </span>
                <h1 class="bolded" id="bal"><?php echo ($vaccine[0]["vaccine_name"]);?></h1>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <div class="well well-sm"><b>Stocks Ledger</b>
            </div>

            <div class="row">
                <div class="col-lg-12" style="margin-top: 10px;">

                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-hover dataTable" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="no-sort"></th>
                                    <th>No.</th>
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
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">Change in Stock Balance!</h4>
            </div>
            <div class="modal-body">
                <p>You have changed the stock balance after a transaction.</p>                     
                <p>You will be redirected to the Stock Adjustment page to update accordingly</p>
            </div>    
        </div>
    </div>
</div>

                    <script type="text/javascript">


                        var url = "<?php echo base_url('stock/stock_data/'.$id) ?>";
                        var editor; // use a global for the submit and return data rendering in the examples

                        $(document).ready(function() {
                            editor = new $.fn.dataTable.Editor({
                                ajax: url,
                                table: "#table",
                                fields: [{
                                    label: "Batch:",
                                    name: "batch"
                                }, {
                                    label: "Quantity:",
                                    name: "quantity"
                                }, {
                                    label: "Stock Balance:",
                                    name: "balance"
                                }]
                            });

                            editor.on('submitSuccess', function (e, json, data){
                                $("#changeModal").modal('show');
                                var redirect = "<?php echo base_url('stock/adjust_stock') ?>";
                                window.setTimeout(function() {
                                    window.location.href = redirect;
                                }, 5000);
                               
                            });

                            // Activate the bubble editor on click of a table cell
                            $('#table').on('click', 'tbody td:not(:first-child)', function(e) {
                                editor.bubble(this);
                            });

                            $('#table').DataTable({
                                dom: "Bfrtip",
                                scrollY: 300,
                                paging: false,
                                ajax: url,
                                columnDefs: [{
                                    targets: [1],
                                    orderData: [1, 0],
                                    visible: false
                                }, {
                                    targets: 'no-sort',
                                    orderable: false
                                }],
                                columns: [{
                                    data: null,
                                    defaultContent: '',
                                    className: 'select-checkbox',
                                    orderable: false
                                }, {
                                    data: "order"
                                }, {
                                    data: "date"
                                }, {
                                    data: "type"
                                }, {
                                    data: "to_from"
                                }, {
                                    data: "quantity"
                                }, {
                                    data: "batch"
                                }, {
                                    data: "expiry"
                                }, {
                                    data: "balance",
                                    render: $.fn.dataTable.render.number(',', '.', 0)
                                }],
                                order: [],
                                select: {
                                    style: 'os',
                                    selector: 'td:first-child'
                                },
                                buttons: [{
                                        extend: "edit",
                                        editor: editor
                                    },
                                    {
                                        extend: "remove",
                                        editor: editor
                                    },
                                    {
                                        extend: 'collection',
                                        text: 'Export',
                                        buttons: [
                                            'copy',
                                            'excel',
                                            'csv',
                                            'pdf',
                                            'print'
                                        ]
                                    }
                                ],
                                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                    
                                    if ( aData['type'] == "Issue" )
                                    {
                                        $('td', nRow).css('color', 'Blue');
                                    }
                                    else if ( aData['type'] == "Receive" )
                                    {
                                        $('td', nRow).css('color', 'Red');
                                    }
                                    else if ( aData['type'] == "Physical Count" )
                                    {
                                        $('td', nRow).css('color', 'black');
                                    }
                                    else if ( aData['type'] == "Adjustment" )
                                    {
                                        $('td', nRow).css('color', 'black');
                                    }
                                }
                            });
                        });
                    </script>