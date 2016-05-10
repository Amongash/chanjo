<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
                                <td><a href="<?php echo base_url('dashboard/index?loc=1&name='.$row['name']) ?>"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2) ?></td>
                                <?php }elseif($user_level == '2') { ?>
                                <td><a href="<?php echo base_url('dashboard/index?loc=2&name='.$row['name']) ?>"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2) ?></td>
                                <?php }elseif($user_level == '3') { ?>
                                <td><a href="<?php echo base_url('dashboard/index?loc=3&name='.$row['name']) ?>"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2) ?></td>
                                <?php }else{ ?>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2) ?></td>
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
                                <td><a href="<?php echo base_url('dashboard/index?loc=1&name='.$row['name']) ?>"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2) ?></td>
                                <?php }elseif($user_level == '2') { ?>
                                <td><a href="<?php echo base_url('dashboard/index?loc=2&name='.$row['name']) ?>"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2) ?></td>
                                <?php }elseif($user_level == '3') { ?>
                                <td><a href="<?php echo base_url('dashboard/index?loc=3&name='.$row['name']) ?>"><?php echo $row['name'] ?></a></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2) ?></td>
                                <?php }else{ ?>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['totaldpt3'] ?></td>
                                <td><?php echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2) ?></td>
                            </tr><?php }} ?>
                        </tbody>
                    </table>
                    <hr>
                    </br>

                </div>

            </div>

        </div>
    </div>
</div>



<br/>


<div class="row">
    <div class="block-web">
        <div class="col-lg-12">

            <div class="col-md-6">
                <h5 class="content-header text-info">Stock Available</h5>

                <div id="morris-bar-chart" name="morris-bar-chart"></div>
            </div>
            <div class="col-md-6">

                <h5 class="content-header text-info">Months of Stock</h5>

                <div id="morris-line-chart" name="morris-line-chart"></div>
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
            <div id="container"></div>


        </div>
    </div>
</div>


<script type="text/javascript">
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
    
  
</script>

<script type="text/javascript">
    nam = "";
    url = "<?php echo base_url('dashboard/get_stock_balance/'.$station);?>";
    $.getJSON(url, function(data) {
        $.each(data, function(key, value) {
            nam = value.name;
            val = value.y;
        });
        $('#morris-bar-chart').highcharts({
            chart: {
                type: 'column'
            },
            loading: {
                hideDuration: 100,
                labelStyle: {
                    "fontWeight": "bold",
                    "position": "relative",
                    "top": "45%"
                },
                showDuration: 100,
                style: undefined
            },
            credits: {
                enabled: false
            },
            title: {
                text: "Stock balance of various vaccines"
            },
            yAxis: {
                title: {
                    text: 'Amount'
                }
            },
            xAxis: {
                 categories: console.log(nam),
                title: {
                    text: 'Vaccine/Diluent'
                }
            },
            series: [{
                data: data,
                name: "stock level"
            }]
        });

    });
</script>


<script type="text/javascript">
    // nam ="";
    // url = "<?php echo base_url('dashboard/months_of_stock/'.$station);?>";
    // $.getJSON(url, function(mts) {
    //     $.each(mts, function(name, value) {
    //         nam = name;
    //         val = value;
    //     });
    //     $('#morris-line-chart').highcharts({

    //         chart: {
    //             type: 'column'
    //         },
    //         credits: {
    //             enabled: false
    //         },
    //         title: {
    //             text: "Months of Stock"
    //         },
    //         yAxis: {
    //             title: {
    //                 text: 'No of Months'
    //             }
    //         },
    //         xAxis: {
    //              categories: nam,
    //             title: {
    //                 text: 'Vaccine/Diluent'
    //             }
    //         },
    //         series: [{
    //             data: mts,
    //             name: "months of stock"
    //         }]
    //     });
    // });
</script>

<script type="text/javascript">
    nam ="";
    url = "<?php echo base_url('dashboard/get_coverage?loc='.$loc.'&name='.$station);?>";
    $.getJSON(url, function(mim) {
        $.each(mim, function(name, value) {
            nam = name;
            val = value;
        });

        $('#container').highcharts({
            chart: {
                type: 'line'
            },
            loading: {
                hideDuration: 100,
                labelStyle: {
                    "fontWeight": "bold",
                    "position": "relative",
                    "top": "45%"
                },
                showDuration: 100,
                style: undefined
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Coverage of Vaccines',
                x: -20 //center
            },
            subtitle: {
                text: 'Source: DHIS',
                x: -20
            },
            xAxis: {
                categories: console.log(nam),
                title: {
                    text: 'Months'
                }
            },
            yAxis: {
                title: {
                    text: 'Coverage (%)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            series: [{
                    data: mim,
                    name: "BCG",
                    turboThreshold: 0
                }

            ]

        });
    });
</script>