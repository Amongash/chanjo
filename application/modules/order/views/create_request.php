<div class="row">
    <div class="col-lg-12">
        <?php
        $form_attributes = array('id' => 'request_form', 'method' => 'post', 'class' => '', 'role' => 'form');
        echo form_open('', $form_attributes); ?>

        <div class="well well-sm"><b>Request Details</b></div>

        <div class="row">
            <div class="col-lg-4">
                <div class="panel-body">
                    <b>Requestor's Name</b><br>
                    <?php $data = array('name' => 'requestor', 'id' => 'requestor', 'class' => 'form-control', 'value' =>$user_object['user_fname'] . ' ' . $user_object['user_lname'], 'readonly' => '');
                    echo form_input($data); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel-body">
                    <b>Send order to</b><br>
                    <?php $data = array('name' => 'to_from', 'id' => 'to_from', 'class' => 'form-control', 'readonly' => '', 'value' => $user_object['statiton_above']);
                    echo form_input($data); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel-body">
                    <b>Today's Date</b><br>
                    <?php $data = array('name' => 'date', 'id' => 'date', 'class' => 'form-control', 'readonly' => '', 'value' => date('Y-m-d', strtotime(date('Y-m-d'))));
                    echo form_input($data); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-body">
                    <b>Lead Time</b><br>
                    <?php $data = array('name' => 'time', 'id' => 'time', 'class' => 'form-control', 'value' =>'', 'readonly' => '');
                    echo form_input($data); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel-body">
                    <b>Last Order Date</b><br>
                    <?php $data = array('name' => 'time', 'id' => 'time', 'class' => 'form-control', 'value' =>'', 'readonly' => '');
                    echo form_input($data); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel-body">
                    <b>Months to order</b><br>
                    <select id="months" class="form-control" required>
                    <option selected value="" required>--Select Duration--</option>
                    <?php for ($i = 1; $i <= 12; $i++) {
                        echo "<option value='" . $i . "'>" . $i . "</option>";
                    } ?>
                </select>
                </div>
            </div>
        </div>
        <input type="hidden" name="transaction_type" class="transaction_type" value="1">
        <br/>

        <div class="table-responsive">
            <div class="well well-sm"><b>Vaccine Details</b></div>

            <div id="request_table">

                <table class="table table-bordered table-hover table-striped">
                    <thead>

                    <th align="center">Vaccine/Diluents</th>
                    <th align="center">Stock In Hand</th>
                    <th align="center">Minimum Stock</th>
                    <th align="center">Maximum Stock</th>
                    <th align="center">First Expiry</th>
                    <th align="center">Quantity</th>
                    <th align="center">Action</th>
                    </thead>
                    <tbody>

                    <tr align="center" request_row="1">

                        <td class="col-xs-2"><select name="vaccine" class="vaccine form-control" id="vaccine" required>
                                <option value="">Select Vaccine</option>
                                <?php foreach ($vaccines as $vaccine) {
                                    echo "<option value='" . $vaccine['id'] . "'>" . $vaccine['vaccine_name'] . "</option>";
                                } ?>
                            </select>
                        </td>

                         <td class="col-xs-2"><?php $data = array('name' => 'current_stock', 'id' => 'current_stock', 'class' => 'form-control current_stock', 'readonly' => '');
                        echo form_input($data); ?> </td>
                        
                        <td class="col-xs-2"><?php $data = array('name' => 'min_stock', 'id' => 'min_stock', 'class' => 'form-control min_stock', 'readonly' => '');
                        echo form_input($data); ?> </td>

                        <td class="col-xs-2"><?php $data = array('name' => 'max_stock', 'id' => 'max_stock', 'class' => 'form-control max_stock', 'readonly' => '');
                        echo form_input($data); ?> </td>

                        <td class="col-xs-2"><?php $data = array('name' => 'expiry_date', 'id' => 'expiry_date', 'class' => 'form-control expiry_date', 'readonly' => '');
                        echo form_input($data); ?> </td>

                        <td class="col-xs-2"><?php $data = array('name' => 'quantity', 'id' => 'quantity', 'class' => 'form-control', 'type' => 'number', 'required' => '', 'min' => '0');
                        echo form_input($data); ?> </td>
                        <td class="small">
                                <a href="#" class="add btn"><span class="label label-success"><i
                                            class="fa fa-plus-square"></i> <b>ADD</b></span></a><br>
                                <a href="#" class="remove btn"><span class="label label-danger"><i
                                            class="fa  fa-minus-square"></i> <b>REMOVE</b></span></a>
                            </td>
                    </tr>

                    </tbody>
                </table>

                <?php echo form_hidden('transaction_date', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'))));  ?>
            </div>

            <input type="button" name="btn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-danger" value="Submit"/>

            <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            Confirm Submit
                        </div>
                        <div class="modal-body">
                            Are you sure you want to submit the entered details?
                        <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
                               <button type="submit" name="stock_received" id="stock_received" class="btn btn-sm btn-danger"><i class="fa fa-paper-plane"></i>Submit<img id="loader" src="<?php echo base_url() ?>assets/images/loader.gif" alt="loading image" hidden></button>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            

            <?php
            echo form_close(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">

    $('#request_table').delegate('.add', 'click', function () {

        var thisRow = $('#request_table tr:last');
        var cloned_object = $(thisRow).clone();

        var request_row = cloned_object.attr("request_row");
        var next_request_row = parseInt(request_row) + 1;
        cloned_object.attr("request_row", next_request_row);

        var vaccine_id = "vaccine" + next_request_row;
        var vaccine = cloned_object.find(".vaccine");
        vaccine.attr('id', vaccine_id);

        
        cloned_object.insertAfter(thisRow).find('input').val('');
        
    });

    $('#request_table').delegate('.remove', 'click', function () {
        if ( $('#request_table tbody tr').length == 1) return;
            $(this).parents("tr").fadeOut('slow', function () {
                $(this).remove();
            });
    });

    $(document).on( 'change','.vaccine', function () {
        var row=$(this);
        var selected_vaccine=$(this).val();
        load_details(selected_vaccine, row);
    });

    function load_details(selected_vaccine, row){

        var _url="<?php echo base_url();?>order/populate_request";

        var request=$.ajax({
            url: _url,
            type: 'post',
            data: {"selected_vaccine":selected_vaccine},

        });

        request.done(function(data){
            data=JSON.parse(data);
            row.closest("tr").find("td .current_stock").val("");
            row.closest("tr").find("td .min_stock").val("");
            row.closest("tr").find("td .max_stock").val("");
            row.closest("tr").find("td .expiry_date").val("");
            $.each(data,function(key,value){
                row.closest("tr").find("td .current_stock").val(value.current_stock);
                row.closest("tr").find("td .min_stock").val(value.min_stock);
                row.closest("tr").find("td .max_stock").val(value.max_stock);
                row.closest("tr").find("td .expiry_date").val(value.expiry_date);
            });
           

        });
        request.fail(function(jqXHR, textStatus) {

        });
    }


    $("#request_form").submit(function (e) {


        $('.fa').removeClass("fa-paper-plane");
        $(this).find("button[type='submit']").prop('disabled',true);
        $(this).find("button[type='submit']").css('background','#fff');
        $(this).find("button[type='submit']").css('cursor','not-allowed');

        e.preventDefault();//STOP default action
        var vaccine_count = 0;
        $.each($(".vaccine"), function (i, v) {
            vaccine_count++;
        });


        var formURL = "<?php echo base_url();?>order/save_request";

        var to_from = retrieveFormValues('to_from');
        var transaction_date = retrieveFormValues('transaction_date');
        var vaccines = retrieveFormValues_Array('vaccine');
        var quantity = retrieveFormValues_Array('quantity');
        var current = retrieveFormValues_Array('current_stock');
        var max = retrieveFormValues_Array('max_stock');
        var min = retrieveFormValues_Array('min_stock');
        var expiry = retrieveFormValues_Array('expiry_date');

        var dat = new Array();
        var get_requestor = requestor;
        var get_to_from = to_from;
        var get_transaction_date = transaction_date;

        for (var i = 0; i < vaccine_count; i++) {
            var data = new Array();
            var get_vaccine = vaccines[i];
            var get_quantity = quantity[i];
            var get_current = current[i];
            var get_max = max[i];
            var get_min = min[i];
            var get_expiry = expiry[i];


            data = {
                "vaccine_id": get_vaccine,
                "quantity" : get_quantity,
                "current" : get_current,
                "max_stock" : get_max,
                "min_stock" : get_min,
                "expiry" : get_expiry
            };
            dat.push(data);
        }
        batch = JSON.stringify(dat);
        $.ajax(
            {
                url: formURL,
                type: "POST",
                data: {
                    "transaction_date": get_transaction_date,
                    "to_from": get_to_from,
                    "batch": batch
                },
                beforeSend: function(){
                    $('#send').prop("hidden", true);
                    $('#cancel').prop("disabled", true);
                    $('#send').prop("disabled", true);
                    $('#loader').css('display','inline');
                   
                },
                success: function (data, textStatus, jqXHR) {
                    //data: return data from server
                    window.location.replace('<?php echo base_url() . 'order/list_orders'?>');


                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //if fails
                }
            });

        // e.unbind(); //unbind. to stop multiple form submit.
    });

    function retrieveFormValues_Array(name) {
        var dump = new Array();
        var counter = 0;
        $.each($("input[name=" + name + "], select[name=" + name + "]"), function (i, v) {
            var theTag = v.tagName;
            var theElement = $(v);
            var theValue = theElement.val();
            /*dump[counter] = theElement.attr("value");*/
            dump[counter] = theValue;

            counter++;
        });
        return dump;
    }

    function retrieveFormValues(name) {
        var dump;
        $.each($("input[name=" + name + "], select[name=" + name + "]"), function (i, v) {
            var theTag = v.tagName;
            var theElement = $(v);
            var theValue = theElement.val();
            dump = theValue;
        });
        return dump;
    }

    
    function retrieveCommentValues_Array(name) {
        var dump = new Array();
        var counter = 0;
         $.each($("textarea[name=" + name + "]"), function (i, v) {
            var theTag = v.tagName;
            var theElement = $(v);
            var theValue = theElement.val();
            /*dump[counter] = theElement.attr("value");*/
            dump[counter] = theValue;

            counter++;
        });
        return dump;
    }

    window.onbeforeunload = function () {

    }

</script>