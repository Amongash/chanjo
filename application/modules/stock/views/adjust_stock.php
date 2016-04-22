
<div class="row">
    <div class="col-lg-12">
        <?php
        $form_attributes = array('id' => 'physical_stock_fm','class'=>'','role'=>'form');
        echo form_open('',$form_attributes);?>

        <div id="physical_stock">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">


                    <thead>
                    <th style="width:9%;" >Vaccine/Diluents</th>
                    <th style="width:9%;" >Batch No.</th>
                    <th style="width:9%;" >Stock </br>Quantity</th>
                    <th style="width:15%;">Reason</th>
                    <th style="width:15%;">Adjustment</th>
                    <th style="width:15%;">More Info</th>
                   

                    </thead>
                    <tbody>

                    <tr physical_row="1">
                        <input type="hidden" name ="transaction_type" class="transaction_type" value="2">
                        <td> <select name="vaccine" class="form-control vaccine" id="vaccine" required>
                                <option value="" selected="selected">Select Vaccine</option>
                                <?php foreach ($vaccines as $vaccine) {
                                    echo "<option value='".$vaccine['id']."'>".$vaccine['vaccine_name']."</option>";
                                }?>
                            </select>
                        </td>
                        <td> <select name="batch_no" class="form-control batch_no" id="batch_no" required ></select></td>
                        <td><?php $data=array('name' => 'quantity','id'=> 'quantity','class'=>'form-control quantity','required'=>'','type'=>'number' ); echo form_input($data);?></td>
                        <td><select name="reason" class="form-control reason" id="reason" required>
                                <option value="" selected="selected">Select Reason</option>
                                <option value="Breakage" >Breakage</option>
                                <option value="Donation In" >Donation In</option>
                                <option value="Donation Out" >Donation Out</option>
                                <option value="Expiry" >Expiry</option>
                                <option value="Miscount" >Miscount </option>
                                <option value="Theft" >Theft</option>                                
                                <option value="VVM Change" >VVM Status Change</option>
                                <option value="Vaccine Damage" >Vaccine Damage</option>
                            </select></td>
                        <td>
                           <label class="radio-inline"><input type="radio" name="adjustment" value="add" id="adjustment">Add</label>
                            <label class="radio-inline"><input type="radio" name="adjustment" value="ded" id="adjustment">Deduct</label>
                        </td>
                        <td><?php  $data = array('name'=> 'comment','id'=> 'comment','rows'=> '2','cols'=> '14','class'=> 'form-control comment'); echo form_textarea($data);?></td>
						<td hidden><?php $data=array('name' => 'row_id','id'=> 'row_id','class'=>'form-control row_id' , 'hidden'=>'' ); echo form_input($data);?></td>
             		
                    </tr>

                    </tbody>
                </table>
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
                                <button type="submit" name="physical_count_fm" id="physical_count_fm" class="btn btn-sm btn-danger">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
            <?php echo form_close();?>
        </div>
    </div>

   




<script type="text/javascript">

    // Add another row in the form on click add

    $('#physical_stock').delegate( '.add', 'click', function () {

        var thisRow =$('#physical_stock tr:last');
        var cloned_object = $( thisRow ).clone();

        var physical_row = cloned_object.attr("physical_row");
        var next_physical_row = parseInt(physical_row) + 1;
        cloned_object.attr("physical_row", next_physical_row);

        var vaccine_id = "vaccine" + next_physical_row;
        var vaccine = cloned_object.find(".vaccine");
        vaccine.attr('id',vaccine_id);

        var batch_id = "batch_no" + next_physical_row;
        var batch = cloned_object.find(".batch_no");
        batch.attr('id',batch_id);

        var quantity_id = "quantity" + next_physical_row;
        var quantity = cloned_object.find(".quantity");
        quantity.attr('id',quantity_id);

        var reason_id = "reason" + next_physical_row;
        var reason = cloned_object.find(".reason");
        reason.attr('id',reason_id);

        var radio_id = "adjustment" + next_physical_row;
        var radio = cloned_object.find(".adjustment");
        radio.attr('id',radio_id);

        cloned_object .insertAfter( thisRow ).find( 'input' ).val( '' );

    });
    // Remove a row from the form
    $('#physical_stock').delegate('.remove', 'click', function(){
        $(this).closest('tr').remove();});


    $("#physical_stock_fm").submit(function(e)
    {
        e.preventDefault();//STOP default action
        var vaccine_count=0;
        $.each($(".vaccine"), function(i, v) {
            vaccine_count++;
        });



        var formURL="<?php echo base_url();?>stock/save_adjust_stock";

        var vaccines = retrieveFormValues_Array('vaccine');
        var batch_no = retrieveFormValues_Array('batch_no');
        var quantity = retrieveFormValues_Array('quantity');
        var reason = retrieveFormValues_Array('reason');
        var id = retrieveFormValues_Array('row_id');
        var adjustment = getRadioVal( document.getElementById('physical_stock_fm'), 'adjustment' );
        var comment = retrieveFormValues_Array('comment');

        for(var i = 0; i < vaccine_count; i++) {
            var get_vaccine=vaccines[i];
            var get_batch=batch_no[i];
            var get_quantity=quantity[i];
            var get_reason=reason[i];
            var get_adjustment=adjustment[i];
            var get_comment=comment[i];
            var get_id=id[i];


            $.ajax(
                {
                    url : formURL,
                    type: "POST",
                    data : {"vaccine":get_vaccine,"batch_no":get_batch,"quantity":get_quantity,"reason":get_reason,"adjustment":get_adjustment,"comment":get_comment,"id":get_id},
                    /* dataType : json,*/
                    success:function(data, textStatus, jqXHR)
                    {
                        window.location.replace('<?php echo base_url().'stock/list_inventory'?>');
                        //data: return data from server
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        //if fails
                    }
                });
        }
        // e.unbind(); //unbind. to stop multiple form submit.
    });


    $(document).on( 'change','.vaccine', function () {
        var stock_row=$(this);
        var selected_vaccine=$(this).val();
        load_batches(selected_vaccine,stock_row);
    });

    function load_batches(selected_vaccine,stock_row){

        var _url="<?php echo base_url();?>stock/get_batches";

        var request=$.ajax({
            url: _url,
            type: 'post',
            data: {"selected_vaccine":selected_vaccine},

        });

        request.done(function(data){
            data=JSON.parse(data);
            console.log(data);
            stock_row.closest("tr").find(".batch_no option").remove();
            stock_row.closest("tr").find(".batch_no ").append("<option value=''>Select batch </option> ");
            $.each(data,function(key,value){
                stock_row.closest("tr").find(".batch_no").append("<option value='"+value.batch_number+"'>"+value.batch_number+"</option> ");

                /*value[0].batch_number;*/

            });
        });
        request.fail(function(jqXHR, textStatus) {

        });
    }

    $(document).on( 'change','.batch_no', function () {
				   var stock_row=$(this);
				   var selected_batch=$(this).val();
			     batch_details(selected_batch,stock_row);
		});

	function batch_details(selected_batch,stock_row){
					var _url="<?php echo base_url();?>stock/get_batch_details";
								
					var request=$.ajax({
						     url: _url,
						     type: 'post',
						     data: {"selected_batch":selected_batch},

				    });
				    request.done(function(data){
					    	data=JSON.parse(data);
							stock_row.closest("tr").find(".row_id").val("");
							    	
				    $.each(data,function(key,value){
				    		stock_row.closest("tr").find(".row_id").val(value.receive_id);
				    });
				                                });
				    request.fail(function(jqXHR, textStatus) {
					  
					});
		}	
    //This function loops the whole form and saves all the input, select, e.t.c. elements with their corresponding values in a javascript array for processing

    function retrieveFormValues_Array(name) {
        var dump = new Array();
        var counter = 0;
        $.each($("input[name=" + name + "], select[name=" + name + "], radio[name=" + name + "]:checked"), function(i, v) {
            var theTag = v.tagName;
            var theElement = $(v);
            var theValue = theElement.val();
            dump[counter] = theValue;

            counter++;
        });
        return dump;
    }

    function retrieveFormValues(name) {
        var dump;
        $.each($("input[name=" + name + "], select[name=" + name + "], radio[name=" + name + "]:checked"), function(i, v) {
            var theTag = v.tagName;
            var theElement = $(v);
            var theValue = theElement.val();
            dump = theValue;
        });
        return dump;
    }

    function getRadioVal(form, name) {
	    var val;
	    // get list of radio buttons with specified name
	    var radios = form.elements[name];
	    
	    // loop through list of radio buttons
	    for (var i=0, len=radios.length; i<len; i++) {
	        if ( radios[i].checked ) { // radio checked?
	            val = radios[i].value; // if so, hold its value in val
	            break; // and break out of for loop
	        }
	    }
	    return val; // return value of checked radio or undefined if none checked
	}

</script>

