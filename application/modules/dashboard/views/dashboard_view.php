<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($user_level != '5') { ?>
<div class="row">
    <div class="block-web">
        <div class="col-lg-12">

            <div class="col-md-6">
                <div class="table-responsive">
                <?php
                 if (isset($_GET['loc'])) {
                    $user_level = (int)$_GET['loc']+1;
                }
                ?>
                    <table id="best" class="table table-bordered table-hover table-striped">
                        <thead>
                             <tr>
                                <?php if ($user_level == '1') { ?>
                                 <th>
                                    <h5 class="content-header text-info">3 Best Performing Regions</h5></th>
                                <?php }elseif($user_level == '2') { ?>
                                <th>
                                    <h5 class="content-header text-info">3 Best Performing Counties</h5></th>
                                <?php }elseif($user_level == '3') { ?>
                                <th>
                                    <h5 class="content-header text-info">3 Best Performing </br>Sub-counties</h5></th>
                                <?php }else { ?>
                                <th>
                                    <h5 class="content-header text-info">3 Best Performing </br>Facilities</h5></th>
                                <?php } ?>
                                <th>
                                    <h5 class="content-header text-info">DPT </br>Coverage %</h5></th>
                                <th>
                                    <h5 class="content-header text-info">Drop Out</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php foreach($best as $row) {?>
                            <tr>
                                <?php if ($user_level == '1') { ?>
                                <td><a class="filter" data-population="<?php echo (int)$row['population'] ?>" id="<?php echo $row['name'] ?>" href="#"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php if ($row['totaldpt1']==0) {
                                  echo 'Inconclusive Data.';
                                }else {
                                  echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
                                } ?></td>
                                <?php }elseif($user_level == '2') { ?>
                                <td><a class="filter" data-population="<?php echo (int)$row['population'] ?>" id="<?php echo $row['name'] ?>" href="#"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php if ($row['totaldpt1']==0) {
                                  echo 'Inconclusive Data.';
                                }else {
                                  echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
                                } ?></td>
                                <?php }elseif($user_level == '3') { ?>
                                <td><a class="filter" data-population="<?php echo (int)$row['population'] ?>" id="<?php echo $row['name'] ?>" href="#"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php if ($row['totaldpt1']==0) {
                                  echo 'Inconclusive Data.';
                                }else {
                                  echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
                                } ?></td>
                                <?php }else{ ?>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php if ($row['totaldpt1']==0) {
                                  echo 'Division by 0';
                                }else {
                                  echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
                                }
                                 ?></td>
                            </tr><?php }} ?>
                        </tbody>
                    </table>
                    <hr>
                    </br>

                </div>

            </div>

            <div class="col-md-6">

                <div class="table-responsive">

                    <table id="worst" class="table table-bordered table-hover table-striped">
                        <thead>

                            <tr>
                                <?php if ($user_level == '1') { ?>
                                 <th>
                                    <h5 class="content-header text-info">3 Poor Performing Regions</h5></th>
                                <?php }elseif($user_level == '2') { ?>
                                <th>
                                    <h5 class="content-header text-info">3 Poor Performing Counties</h5></th>
                                <?php }elseif($user_level == '3') { ?>
                                <th>
                                    <h5 class="content-header text-info">3 Poor Performing </br>Sub-counties</h5></th>
                                <?php }elseif($user_level == '4') { ?>
                                <th>
                                    <h5 class="content-header text-info">3 Poor Performing </br>Facilities</h5></th>
                                <?php }else{ ?>
                                 <th>
                                    <h5 class="content-header text-info">3 Poor Performing </br>Facilities</h5></th>
                                 <?php } ?>
                                <th>
                                    <h5 class="content-header text-info">DPT </br>Coverage %</h5></th>
                                <th>
                                    <h5 class="content-header text-info">Drop Out</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  foreach($worst as $row) {   ?>
                            <tr>
                                <?php if ($user_level == '1') { ?>
                                <td><a class="filter" data-population="<?php echo (int)$row['population'] ?>" id="<?php echo $row['name'] ?>" href="#"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php if ($row['totaldpt1']==0) {
                                  echo 'Inconclusive Data.';
                                }else {
                                  echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
                                }
                                 ?></td>
                                <?php }elseif($user_level == '2') { ?>
                                <td><a class="filter" data-population="<?php echo (int)$row['population'] ?>" id="<?php echo $row['name'] ?>" href="#"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php if ($row['totaldpt1']==0) {
                                  echo 'Inconclusive Data.';
                                }else {
                                  echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
                                }

                                 ?></td>
                                <?php }elseif($user_level == '3') { ?>
                                <td><a class="filter" data-population="<?php echo (int)$row['population'] ?>" id="<?php echo $row['name'] ?>" href="#"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php if ($row['totaldpt1']==0) {
                                  echo 'Inconclusive Data.';
                                }else {
                                  echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
                                }

                                 ?></td>
                                <?php }else{ ?>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php if ($row['totaldpt1']==0) {
                                  echo 'Division by 0';
                                }else {
                                  echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
                                }
                                 ?></td>
                            </tr><?php }} ?>
                        </tbody>
                    </table>
                    <hr>
                    </br>

                </div>

            </div>

        </div>
    </div>
</div><?php }else {?>
  <div>

  </div>
<?php } ?>



<br/>


<div class="row">
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


<div class="row">
    <div class="block-web">
        <div class="col-lg-12">

            <h5 class="content-header text-info">Coverage</h5>
            </br>
            <div id="coverage" name="coverage"></div>


        </div>
    </div>
</div>

<div class="row">
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
    ajax_fill_data('dashboard/positiveColdchain',"#positive");
    ajax_fill_data('dashboard/negativeColdchain',"#negative");
    ajax_fill_data('dashboard/coverage/NULL',"#coverage");

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

        $( ".filter" ).click(function() {
          var population=$(this).attr('data-population');
          var name=$(this).attr('id');
          //var change=true;
          ajax_fill_data('dashboard/vaccineBalance/'+name,"#stocks");
          ajax_fill_data('dashboard/vaccineBalancemos/'+name+'/'+population,"#mos");
          //ajax_fill_data('dashboard/coverage/'+name,"#coverage");
        });


</script>
