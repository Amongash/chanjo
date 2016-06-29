<style>
    .custom-select {
        width: 20%;
        height: 40px !important;
        font-size: 1.2em !important;
        font-weight: bolder;
        margin-left: 2.6%;
    }
    #filter_all {
        height: 40px !important;
        margin-left: 2.6%;
        margin-top: 10%;
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
        <div class="col-lg-3">
            <div class="panel-body">
               
                <br> <select class="form-control custom-select  " name="vaccine" id="vaccine" required="true">
                <option value="0">Select Vaccine</option>
                <?php foreach ($vaccines as $vaccine) { echo "<option value='" . $vaccine[ 'id'] . "'>" . $vaccine[ 'vaccine_name'] . "</option>"; } ?>
                </select>

            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel-body">
                
                <br> <?php $data=array( 'name'=> 'quantity', 'id' => 'quantity', 'class' => 'form-control custom-select quantity', 'placeholder' => 'Enter Quantity', 'min' => '0'); echo form_input($data); ?>

            </div>
        </div>

        <div class="col-lg-3">
            <div class="panel-body">
               
                <br> <select class="form-control custom-select  " name="vaccine" id="vaccine" required="true">
                <option value="Null">Select Allocation Method</option>
                <option value="Target Population">Target Population</option>
                <option value="Average Consumption">Average Consumption</option>
                </select>

            </div>
        </div>

        <div class="col-lg-3">
            <div class="panel-body">
                 <button class="btn btn-success btn-lg" name="filter_all" id="filter_all" type="submit">Generate</button>
            </div>
        </div>





    </div>
</div>