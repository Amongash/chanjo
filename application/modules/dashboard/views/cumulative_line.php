<!--<script src="<?php //echo base_url() ?>assets/js/jquery-2.1.0.js"></script>
<script src="<?php //echo base_url() ?>assets/plugins/highcharts/highcharts.js" type="text/javascript"></script>
<script src="<?php //echo base_url() ?>assets/plugins/highcharts/modules/no-data-to-display.js"></script>
<script src="<?php //echo base_url() ?>assets/plugins/highcharts/modules/exporting.js"></script>-->

<script>
$(function () {
    $('#<?php echo $graph_id; ?>').highcharts({
        title: {
            text: <?php echo $station; ?>,
            x: -20 //center
        },
        colors: ['#C81919', '#199EC8'],
        subtitle: {
            text: 'Source: ',
            x: -20
        },
        xAxis: {
            categories: <?php echo $time_data; ?>
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Cumulative Population Target',
            data:  <?php echo $cumulative_population; ?>
        }, {
            name: <?php echo $vaccine; ?> ,
            data: <?php echo $cumulative_antigen_administered; ?>
        }]
    });
});

</script>
<div id="<?php echo $graph_id; ?>"></div>
