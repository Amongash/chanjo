<!--<script src="<?php //echo base_url() ?>assets/js/jquery-2.1.0.js"></script>
<script src="<?php //echo base_url() ?>assets/plugins/highcharts/highcharts.js" type="text/javascript"></script>
<script src="<?php //echo base_url() ?>assets/plugins/highcharts/modules/no-data-to-display.js"></script>
<script src="<?php //echo base_url() ?>assets/plugins/highcharts/modules/exporting.js"></script>-->

<script>
$(function () {
    $('#<?php echo $graph_id; ?>').highcharts({
        title: {
            text: 'Coverage',
            x: -20 //center
        },
        subtitle: {
            text: 'Source: ',
            x: -20
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: <?php echo $time_data; ?>
        },
        yAxis: {
            title: {
                text: '%'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '%'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'BCG',
            data:  <?php echo $bcg; ?>
        }, {
            name: 'DPT1',
            data: <?php echo $dpt1; ?>
        },
        {
            name: 'DPT2',
            data: <?php echo $dpt2; ?>
        },
        {
            name: 'DPT3',
            data: <?php echo $dpt3; ?>
        },
        {
            name: 'Measles 1',
            data: <?php echo $measles1; ?>
        },
        {
            name: 'Measles 2(at 1 12 - 2 years)',
            data: <?php echo $measles2; ?>
        },
        {
            name: 'Measles 2 above 2 years',
            data: <?php echo $measles3; ?>
        },
        {
            name: 'OPV1',
            data: <?php echo $opv1; ?>
        },
        {
            name: 'OPV2',
            data: <?php echo $opv2; ?>
        },
        {
            name: 'OPV2',
            data: <?php echo $opv2; ?>
        },
        {
            name: 'OPV3',
            data: <?php echo $opv3; ?>
        },
        {
            name: 'PVC1',
            data: <?php echo $pvc1; ?>
        },
        {
            name: 'PVC2',
            data: <?php echo $pvc2; ?>
        },
        {
            name: 'PVC3',
            data: <?php echo $pvc3; ?>
        },
        {
            name: 'ROTA1',
            data: <?php echo $rota1; ?>
        },
        {
            name: 'ROTA2',
            data: <?php echo $rota2; ?>
        }]
    });
});

</script>
<div id="<?php echo $graph_id; ?>"></div>
