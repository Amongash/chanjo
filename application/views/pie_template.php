<!--<script src="<?php //echo base_url() ?>assets/js/jquery-2.1.0.js"></script>
<script src="<?php // echo base_url() ?>assets/plugins/highcharts/highcharts.js" type="text/javascript"></script>
<script src="<?php //echo base_url() ?>assets/plugins/highcharts/modules/no-data-to-display.js"></script>
<script src="<?php // echo base_url() ?>assets/plugins/highcharts/modules/exporting.js"></script>-->
<script>
$(function () {
$('#<?php echo $graph_id; ?>').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: '<?php echo $graph_title; ?>'
    },
    credits: {
            enabled: false
        },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>: <b>{point.y} Lts</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Used Capacity',
            y: <?php echo $piedata ;?>
        },
        {
            name: 'Free Capacity',
            y: <?php echo $remaining_volume ;?>,
        }]
    }]
});
});
</script>

<div id="<?php echo $graph_id; ?>"></div>
