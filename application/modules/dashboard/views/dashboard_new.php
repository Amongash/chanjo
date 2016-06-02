<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($user_level != '5') { ?>
<div class="row" style="min-height:200px">
    <div class="block-web">
        <div class="col-lg-12">

            <div class="col-md-6">

                <div class="table-responsive" id="best" >

                </div>

            </div>

            <div class="col-md-6">

                <div class="table-responsive">

                  <div class="table-responsive" id="worst">

                  </div>



                </div>

            </div>

        </div>
    </div>
</div><?php }else {?>
  <div>

  </div>
<?php } ?>



<br/>


<div class="row" style="min-height:300px">
    <div class="block-web">
        <div class="col-lg-12">

            <div class="col-md-6">
                <h5 class="content-header text-info">Stock Available</h5>

                <div id="stocks" name="stocks"></div>
            </div>
            <div class="col-md-6">

                <h5 class="content-header text-info">Months of Stock</h5>

                <div id="mos" name="mos"></div>
            </div>

        </div>
    </div>
</div>


<br/>


<div class="row" style="min-height:300px">
    <div class="block-web">
        <div class="col-lg-12">

            <h5 class="content-header text-info">Coverage</h5>
            </br>
            <div id="coverage" name="coverage"></div>


        </div>
    </div>
</div>

<div class="row" style="min-height:300px">
    <div class="block-web">
        <div class="col-lg-12">

            <div class="col-md-6">
                <h5 class="content-header text-info">+ve Cold Chain</h5>

                <div id="positive" name="positive"></div>
            </div>
            <?php if ($user_level!=5) {
              # code...
            ?>
            <div class="col-md-6">

                <h5 class="content-header text-info">-ve Cold Chain</h5>

                <div id="negative" name="negative"></div>
            </div>

            <?php } ?>

        </div>
    </div>
</div>


<script type="text/javascript">

var url="<?php echo base_url(); ?>";

    <?php
    if ($user_level == '1') {
        $option = '1';
    } elseif ($user_level == '2') {
        $option = '2';
    } elseif ($user_level == '3') {
        $option = '3';
    } elseif ($user_level == '4') {
        $option = '4';
    }
    ?>

    ajax_fill_data('dashboard/vaccineBalance/NULL',"#stocks");
    ajax_fill_data('dashboard/vaccineBalancemos/NULL/NULL',"#mos");
    ajax_fill_data('dashboard/positiveColdchain/NULL/NULL',"#positive");
    ajax_fill_data('dashboard/negativeColdchain',"#negative");
    ajax_fill_data('dashboard/coverage/NULL',"#coverage");
    ajax_fill_data('dashboard/best/NULL/NULL',"#best");
    ajax_fill_data('dashboard/worst/NULL/NULL',"#worst");

    function ajax_fill_data(function_url,div){
        var function_url =url+function_url;
        var loading_icon=url+"assets/images/loader.gif";
        $.ajax({
        type: "POST",
        url: function_url,
        beforeSend: function() {
        $(div).html("<img style='margin:20% 50% 0 50%;' src="+loading_icon+">");
        },
        success: function(msg) {
        $(div).html(msg);
        }
        });
        }




</script>
