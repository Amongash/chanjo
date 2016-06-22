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
            <td><a class="filter" data-escalate="<?php echo $user_level ?>" data-population="<?php echo (int)$row['population'] ?>" id="<?php echo $row['name'] ?>" href="#"><?php echo $row['name'] ?></a></td>
            <td><?php echo $row['totaldpt3'] ?></td>
            <td><?php if ($row['totaldpt1']==0) {
              echo 'N/A.';
            }else {
              echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
            }
             ?></td>
            <?php }elseif($user_level == '2') { ?>
            <td><a class="filter" data-escalate="<?php echo $user_level ?>" data-population="<?php echo (int)$row['population'] ?>" id="<?php echo $row['name'] ?>" href="#"><?php echo $row['name'] ?></a></td>
            <td><?php echo $row['totaldpt3'] ?></td>
            <td><?php if ($row['totaldpt1']==0) {
              echo 'N/A.';
            }else {
              echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
            }

             ?></td>
            <?php }elseif($user_level == '3') { ?>
            <td><a class="filter" data-escalate="<?php echo $user_level ?>" data-population="<?php echo (int)$row['population'] ?>" id="<?php echo $row['name'] ?>" href="#"><?php echo $row['name'] ?></a></td>
            <td><?php echo $row['totaldpt3'] ?></td>
            <td><?php if ($row['totaldpt1']==0) {
              echo 'N/A.';
            }else {
              echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
            }

             ?></td>
            <?php }else{ ?>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['totaldpt3'] ?></td>
            <td><?php if ($row['totaldpt1']==0) {
              echo 'N/A.';
            }else {
              echo round(($row['totaldpt1'] - $row['totaldpt3'])/$row['totaldpt1']*100, 2);
            }
             ?></td>
        </tr><?php }} ?>
    </tbody>
</table>

<script type="text/javascript">

var url="<?php echo base_url(); ?>";



        $( ".filter" ).click(function() {

          var population=$(this).attr('data-population');
          var escalate=$(this).attr('data-escalate');
          var name=$(this).attr('id');
          //var x=escalate++;
          increase(escalate);
          console.log(a);
          console.log(name);

          ajax_fill_data('dashboard/vaccineBalance/'+name,"#stocks");
          ajax_fill_data('dashboard/vaccineBalancemos/'+name+'/'+population,"#mos");
          ajax_fill_data('dashboard/worst/'+a+'/'+name,"#worst");
          ajax_fill_data('dashboard/coverage/'+name+'/'+a,"#coverage");
          ajax_fill_data('dashboard/negativeColdchain/'+a+'/'+name,"#negative");
          ajax_fill_data('dashboard/positiveColdchain/'+a+'/'+name,"#positive");


        });

        function increase(escalate){
                a=parseInt(escalate)+1;
                return a;

            }


</script>
