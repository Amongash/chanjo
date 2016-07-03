<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-12">
        <?php
        $vvm = array(
            '1'  => 'Stage 1',
            '2'  => 'Stage 2',
            );
        $form_attributes = array('id' => 'issuestock_fm', 'method' => 'post', 'class' => '', 'role' => 'form');
        echo form_open('', $form_attributes); ?>

        <div class="well well-sm"><b>Transaction Details</b></div>

        <div class="row">
            <div class="col-lg-3">
                <div class="panel-body">
                    <b>Vaccine</b><br>
                    <select name="vaccine" class="form-control vaccine" id="vaccine" required="true">
                        <option value="0">Select Vaccine</option>
                        <?php foreach ($vaccines as $vaccine) {
                            echo "<option value='" . $vaccine['id'] . "'>" . $vaccine['vaccine_name'] . "</option>";
                        } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="panel-body">
                    <b>Stock Balance</b><br>
                    <?php $data = array('name' => 'total_quantity', 'id' => 'total_quantity', 'class' => 'form-control total_quantity', 'readonly' => '', 'value' => '');
                                echo form_input($data); ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="panel-body">
                    <b>Allocated Quantity</b><br>
                    <?php $data = array('name' => 'allocated_quantity', 'id' => 'allocated_quantity', 'class' => 'form-control allocated_quantity', 'readonly' => '', 'value' => '');
                                echo form_input($data); ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="panel-body">
                    <b>Available Quantity</b><br>
                    <?php $data = array('name' => 'remaining_quantity', 'id' => 'remaining_quantity', 'class' => 'form-control remaining_quantity', 'readonly' => '', 'value' => '');
                                echo form_input($data); ?>
                </div>
            </div>
        </div>

        <div id="stock_issue" class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <div class="well well-sm"><b>Vaccine Details</b></div>


                    <table class="table table-bordered table-hover table-striped" id="issue_table">
                        <thead>

                        <th style="width:10%;">Date Issued</th>
                        <th style="width:12%;">Location</th>
                        <th style="width:11%;">Batch No.</th>
                        <th style="width:10%;">S11</th>
                        <th style="width:10%;">Expiry </br>Date</th>
                        <th style="width:9%;">Stock </br>Quantity</th>
                        <th style="width:12%;">Amount </br>Issued</th>
                        <th style="width:11%;">VVM Status</th>
                        <th style="width:7%;">Action</th>
                        </thead>
                        <tbody>
                        <tr issue_row="1" id="stock_row">
                            
                            <td><?php $data = array('name' => 'date_issued', 'required' => 'true', 'id' => 'date_issued', 'required' => 'true', 'type' => 'date', 'class' => 'form-control date_issued');
                                echo form_input($data); ?></td>
                            <td><select name="issued_to" class="form-control issued_to" id="issued_to" required="true">
                                    <option value="">Select Location</option>
                                    <?php foreach ($locations as $row) {
                                        echo "<option value='" . $row->location . "'>" . $row->location . "</option>";
                                    } ?>
                                </select></td>
                            <td><select name="batch_no" class="form-control batch_no" id="batch_no"
                                        required="true"></select></td>
                            <td><?php $data = array('name' => 'voucher', 'id' => 'voucher', 'class' => 'form-control voucher');
                                echo form_input($data); ?></td>            
                            <td><?php $data = array('name' => 'expiry_date', 'id' => 'expiry_date', 'class' => 'form-control expiry_date', 'required' => 'true', 'readonly' => '');
                                echo form_input($data); ?></td>
                            <style type="text/css">
                                input[id="available_quantity"] {
                                    background-color: #E0F2F7 !important
                                }</style>
                            <td class="available"><?php $data = array('name' => 'available_quantity', 'id' => 'available_quantity', 'class' => 'form-control available_quantity', 'readonly' => '', 'value' => '');
                                echo form_input($data); ?></td>
                            <td><?php $data = array('name' => 'amt_issued', 'id' => 'amt_issued', 'class' => 'form-control amt_issued', 'type' => 'number', ' min' => '0', 'required' => 'true', 'disabled' => '');
                                echo form_input($data); ?></td>
                            <td>
                                <select name="vvm_status" class="form-control vvm_status" id="vvm_status" required="true">
                                    <option value="">Select Status</option>
                                    <?php foreach ($vvm as $key=>$value) {
                                        echo "<option value='" . $key . "'>" . $value . "</option>";
                                    } ?>
                                </select>
                            </td>
                            <td hidden>
                                 <?php $data = array('name' => 'remaining', 'id' => 'remaining', 'class' => 'form-control remaining', 'value' => '');
                                echo form_input($data); ?>
                            </td>
                            <td class="small">
                                <a href="#" class="add btn"><span class="label label-success"><i
                                            class="fa fa-plus-square"></i> <b>ADD</b></span></a><br>
                                <a href="#" class="remove btn"><span class="label label-danger"><i
                                            class="fa  fa-minus-square"></i> <b>REMOVE</b></span></a>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

   <input type="button" name="btn" id = "send" data-toggle="modal" data-target="#confirm-submit" class="btn btn-danger" value="Submit"/>
             
    <!--
    <button type="submit" name="stock_issue_fm" id="stock_issue_fm" class="btn btn-sm btn-danger">Submit</button> -->


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
                    <button type="submit" name="stock_issue_fm" id="stock_issue_fm" class="btn btn-sm btn-danger"><i class="fa fa-paper-plane"></i>Submit<img id="loader" src="<?php echo base_url() ?>assets/images/loader.gif" alt="loading image" hidden></button>
                </div>
            </div>
        </div>
    </div>  
</div>

 <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
            
                <div class="modal-body">
                    <p>You are about to empty all table values entered, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <a class="btn btn-danger btn-ok" href="javascript:void(0)" onclick="resetTableValues();">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal js-loading-bar">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-body">
           <div class="progress progress-popup">
            <div class="progress-bar"></div>
           </div>
         </div>
       </div>
     </div>
    </div>

    <?php

    echo form_close(); ?>


    <script type="text/javascript">

        $('#date_issued').datepicker({dateFormat: "yy-mm-dd", maxDate: 0}).datepicker('setDate', null);
        // Add another row in the form on click add
        var form = $('#stock_issue .add');
        var remainder = 0;

         $(document).on('click', '#stock_issue .add', function () {
            var thisRow = $('#stock_issue tr:last');
            var cloned_object = $(thisRow).clone();

            var issue_row = cloned_object.attr("issue_row");
            var next_issue_row = parseInt(issue_row) + 1;
            cloned_object.attr("issue_row", next_issue_row);

            
            var date_id = "date_issued" + next_issue_row;
            var date = cloned_object.find(".date_issued");
            date.removeClass("hasDatepicker").attr('id', date_id).datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: 0,
                setDate: null
            });

            var vaccine_id = "vaccine" + next_issue_row;
            var vaccine = cloned_object.find(".vaccine");
            vaccine.attr('id', vaccine_id);

            var batch_id = "batch_no" + next_issue_row;
            var batch = cloned_object.find(".batch_no");
            batch.attr('id', batch_id);

            var voucher_id = "voucher" + next_issue_row;
            var voucher = cloned_object.find(".voucher");
            voucher.attr('id', voucher_id);

            var expiry_id = "expiry_date" + next_issue_row;
            var expiry = cloned_object.find(".expiry_date");
            expiry.attr('id', expiry_id);

            var amt_issued_id = "amt_issued" + next_issue_row;
            var amt_issued = cloned_object.find(".amt_issued");
            amt_issued.attr('id', amt_issued_id);

            var quantity_id = "available_quantity" + next_issue_row;
            var quantity = cloned_object.find(".available_quantity");
            quantity.attr('id', quantity_id);
            console.log(quantity.val());

            var vvm_id = "vvm" + next_issue_row;
            var vvm_status = cloned_object.find(".vvm_s");
            vvm_status.attr('id', vvm_id);


            cloned_object.insertAfter(thisRow).find('input').val('');

        });

        // Remove a row from the form
        $('#stock_issue').delegate('.remove', 'click', function () {
             if ( $('#stock_issue tbody tr').length == 1) return;
            $(this).parents("tr").fadeOut('slow', function () {
                $(this).remove();
            });
        });


        $("#issuestock_fm").submit(function (e) {

            $('.fa').removeClass("fa-paper-plane");
            $(this).find("button[type='submit']").prop('disabled',true);
            $('#submit').css('background','#fff');
            $(this).find("button[type='submit']").css('cursor','not-allowed');

            e.preventDefault();//STOP default action
            //$("#confirm-submit").modal('hide');
            var location = 0;
            $.each($(".issued_to"), function (i, v) {
                location++;
            });


            var formURL = "<?php echo base_url();?>stock/save_issued_many";

            var vaccines = retrieveFormValues('vaccine');
            var date_issued = retrieveFormValues_Array('date_issued');
           
            var s11 = retrieveFormValues_Array('voucher');

            var issued_to = retrieveFormValues_Array('issued_to');
            var batch_no = retrieveFormValues_Array('batch_no');
            var expiry_date = retrieveFormValues_Array('expiry_date');
            var vvm_status = retrieveFormValues_Array('vvm_status');
           
            var quantity = retrieveFormValues('remaining');
            var amt_issued = retrieveFormValues_Array('amt_issued');


            var dat = new Array();
            
            var get_vaccine = vaccines;

            

            for (var i = 0; i < location; i++) {
                var data = new Array();
                var get_date_issued = date_issued[i];
                var get_s11 = s11[i];
                var get_issued_to = issued_to[i];
                var get_batch = batch_no[i];
                var get_expiry = expiry_date[i];
                
                var get_amount_issued = amt_issued[i];
                var get_quantity = quantity;
                var get_vvm_status = vvm_status[i];


                data = {
                    "vaccine": get_vaccine,
                        
                    "s11": get_s11,
                    "date_issued": get_date_issued,
                    "issued_to": get_issued_to,
                    "batch_no": get_batch,
                    "expiry_date": get_expiry,
                   
                    "amount_issued": get_amount_issued,
                    "quantity": get_quantity,
                    "vvm_status": get_vvm_status
                };
                dat.push(data);
            }
          
            batch = JSON.stringify(dat);
            $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: {
                        
                        "batch": batch
                    },

                   beforeSend: function(){
                        $('#send').prop("hidden", true);
                        $('#cancel').prop("disabled", true);
                        $('#send').prop("disabled", true);
                        $('#loader').css('display','inline');
                        
                    },
                    
                    success: function (data, textStatus, jqXHR) {
                        //console.log(data);
                        window.location.replace('<?php echo base_url() . 'stock/list_issue_stock'?>');
                        //data: return data from server
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        //if fails
                    }
                });

            

            // e.unbind(); //unbind. to stop multiple form submit.
        });

        
        $(document).on('change', '.issued_to', function () {
            var stock_row = $(this);
            var selected_vaccine =  $('.vaccine').val();

            load_batches(selected_vaccine, stock_row);
        });

        $(document).on('change', '.vaccine', function () {
            var selected_vaccine = $(this).val();
            load_balance(selected_vaccine);

            issued_to = retrieveFormValues_Array('issued_to');
            batch_no = retrieveFormValues_Array('batch_no');  
            amt_issued = retrieveFormValues_Array('amt_issued');
           

           if ( issued_to != ""|| batch_no != "" || amt_issued != "")
            {
                $('#confirm-delete').modal('show');
            }
            
            
        });


        function resetTableValues(){


          $('.issued_to').val("") ;
          $('.date_issued').val("") ;
          $('.voucher').val("") ;
          $('.expiry_date').val("") ;
          $('.amt_issued').val("") ;
          $('.batch_no').val("") ;
          $('.vvm_status').val("") ;
          $('.available_quantity').val("") ;
          $('.allocated_quantity').val("") ;
          $('.remaining_quantity').val("") ;
          $('#confirm-delete').modal('hide');
          
        }

        $(document).on('change', '.amt_issued', function () {
            var totals=0;
            var $dataRows=$("#issue_table");
    
            $dataRows.each(function() {
                $(this).find('.amt_issued').each(function(){        
                    totals+=parseInt( $(this).val());
                });

            });
        
           $(".allocated_quantity").each(function(){  
                if (totals>0 && !isNaN(totals)) {
                    $(this).val(totals);
                } else{
                    $(this).val("");
                };
            });

           $(".remaining_quantity").each(function(){  

                var total = $(".total_quantity").val();  
                var allocated = $(".allocated_quantity").val();        
                var remainder = total-allocated;
                if (remainder>0 && !isNaN(remainder)) {
                    $(this).val(remainder);                    

                } else{
                    $(this).val("");
                };
                
            });

            $(".remaining").each(function(){  
                var stock_row = $(this);
                var bal = stock_row.closest("tr").find(".available_quantity").val();
                var issued = stock_row.closest("tr").find(".amt_issued").val();
                

                var remaining = bal-issued;
                console.log(remaining);
                if (remaining>0 && !isNaN(remaining)) {
                    stock_row.closest("tr").find(".remaining").val(remaining);
                } else{
                    stock_row.closest("tr").find(".remaining").val("");
                };
                
            });        
           

        });
           
       

        function load_balance(selected_vaccine) {

            var _url = "<?php echo base_url();?>stock/get_stock_balance/"+selected_vaccine;

            var request = $.ajax({
                url: _url
            });
            request.done(function (data) {
                $(".total_quantity").val(data);
            });
            request.fail(function (jqXHR, textStatus) {

            });
        }

        function load_batches(selected_vaccine, stock_row) {

            var _url = "<?php echo base_url();?>stock/get_batches";

            var request = $.ajax({
                url: _url,
                type: 'post',
                data: {"selected_vaccine": selected_vaccine},

            });
            request.done(function (data) {
                data = JSON.parse(data);
                console.log(data);
                stock_row.closest("tr").find(".batch_no option").remove();
                stock_row.closest("tr").find(".expiry_date ").val("");
                stock_row.closest("tr").find(".available_quantity").val("");
                stock_row.closest("tr").find(".vvm_status").val("");
                stock_row.closest("tr").find(".batch_no ").append("<option value=''>Select batch </option> ");
                $.each(data, function (key, value) {
                    stock_row.closest("tr").find(".batch_no").append("<option value='" + value.batch_number + "'>" + value.batch_number + "</option> ");
        $('.amt_issued').prop("disabled", false);
         });
            });
            request.fail(function (jqXHR, textStatus) {

            });
     
        }


        $(document).on('change', '.batch_no', function () {
            var stock_row = $(this);
            var selected_batch = $(this).val();
            batch_details(selected_batch, stock_row);
        });

        function batch_details(selected_batch, stock_row) {
            var _url = "<?php echo base_url();?>stock/get_batch_details";

            var request = $.ajax({
                url: _url,
                type: 'post',
                data: {"selected_batch": selected_batch},

            });
            request.done(function (data) {
                data = JSON.parse(data);
                console.log(data);
                stock_row.closest("tr").find(".expiry_date ").val("");
                stock_row.closest("tr").find(".available_quantity").val("");
                stock_row.closest("tr").find(".vvm_status").val("");
                $.each(data, function (key, value) {
                    stock_row.closest("tr").find(".expiry_date").val(value.expiry_date);
                    stock_row.closest("tr").find(".available_quantity").val(value.stock_balance);
                    // stock_row.closest("tr").find(".vvm_status").val(value.status);
                    stock_row.closest("tr").find(".amt_issued").attr('max', value.stock_balance);

                });
            });
            request.fail(function (jqXHR, textStatus) {

            });
        }

        //This function loops the whole form and saves all the input, select, e.t.c. elements with their corresponding values in a javascript array for processing

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

    </script>
  
