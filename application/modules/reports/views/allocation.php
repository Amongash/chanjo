<style>
    .custom-select {
        width: 20%;
        height: 40px !important;
        font-size: 1.2em !important;
        font-weight: bolder;
        margin-left: 2.6%;
    }
    .custom-button {
        height: 40px !important;
        margin-left: 22.7%;
        margin-top: 6%;
        border-radius: 0 !important;
    }
    #actions {
        margin-left: 2.6%;
        border-radius: 0 !important;
    }
    .modal-body {
        font-size: 1.2em !important;
    }
</style>
<div class="row">
    <div class="form-inline">
        <div class="col-lg-2">
            <div class=" ">
               
                <br> <select class="form-control custom-select  " name="vaccine" id="vaccine" required="true">
                <option value="">Select Vaccine</option>
                <?php foreach ($vaccines as $vaccine) { echo "<option value='" . $vaccine[ 'id'] . "'>" . $vaccine[ 'vaccine_name'] . "</option>"; } ?>
                </select>

            </div>
        </div>
        <div class="col-lg-3">
            <div class=" ">
                
                <br> <?php $data=array( 'name'=> 'quantity', 'id' => 'quantity', 'class' => 'form-control custom-select quantity', 'placeholder' => 'Enter Quantity', 'min' => '0', 'required' => 'true'); echo form_input($data); ?>

            </div>
        </div>

        <div class="col-lg-3">
            <div class=" ">
               
                <br> <select class="form-control custom-select  " name="allocation" id="allocation" required="true">
                <option value="">Select Allocation Method</option>
                <option value="target_population">Target Population</option>
                <option value="average_consumption">Average Consumption</option>
                </select>

            </div>
        </div>

        <div class="col-lg-4">
            <div class=" ">
                 <button class="btn btn-success btn-lg custom-button" name="submit" id="submit">Generate</button>
                 <button class="btn btn-success btn-lg custom-button" name="save" id="save">Save</button>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-lg-12" style="margin-top: 10px;">

        <div class="table-responsive" id="table">
            <table id="data" class="table table-striped table-hover dataTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Population</th>
                        <th>Stock Balance</th>
                        <th>MOS</th>
                        <th>Quantity</th>
                        
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>Location</th>
                        <th>Population</th>
                        <th>Stock Balance</th>
                        <th>MOS</th>
                        <th>Quantity</th>
                        
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function(){
    var table = $('#data').DataTable({

        "stateSave": true,
        "columns": [
            { "data": "name" },
            { "data": "population" },
            { "data": "balance" },
            { "data": "mos" },
            { "data": "quantity",
                render: function ( data, type, row, meta ) {
                  
                  return '<input type="number" class="form-control small" value="'+Math.round(row.y*row.quantity)+'">';
                }
            }
        ]
    });

    $("#submit").click(function (e) {
        _vaccine = $('#vaccine').val();
        _url = $('#allocation').val();
        _quantity = $('#quantity').val();
        if (_vaccine != '') {
            if(_quantity != '' || quantity < 0){
                if(_url != ''){
                    url = "<?php echo base_url('reports') ?>"+'/'+ _url+'/'+_vaccine+'/'+_quantity;
                    url = encodeURI(url);
                    table.ajax.url(url).load();
                }else{
                    alert('Please select an allocation method');
                }

                    
            }else{
                alert('Please check the value entered');
            }
        }else{
            alert('Please select an antigen');
        }
        
        

    });

});

</script>
