<div class="">
  <div style="min-height: 400px;" id="reports_display">
    <table  class="table table-bordered table-hover table-striped" id="" >
  <thead style="background-color: white">
  <tr>
    <th>Station</th>
    <th>Date</th>
    <th>Population</th>
    <th>BCG</th>
    <th>OPV 0 </th>
    <th>OPV 1 </th>
    <th>OPV 2 </th>
    <th>OPV 3 </th>
    <th>DPT 1 </th>
    <th>DPT 2 </th>
    <th>DPT 3 </th>
    <th>PCV 1 </th>
    <th>PCV 2 </th>
    <th>PCV 3 </th>
    <th>ROTA 1 </th>
    <th>ROTA 2 </th>
    <th>Measles 1 </th>
    <th>Measles 2(at 1 12 - 2 years) </th>
    <th>Measles 2 above 2 years</th>

    <th>Dropout Rate</th>
    <th>Gap Analysis</th>
  </tr>
  </thead>

    <tbody>

    <?php

        foreach ($query as $key => $value ) {

                //$formatdate = new DateTime($potential_exp->expiry_date);
                //$formated_date= $formatdate->format('d M Y');
				        //$ts1 = strtotime(date('d M Y'));
                //$ts2 = strtotime(date($potential_exp->expiry_date));

                ?>
            <tr>
              <td><?php echo $value->station; ?> </td>
              <td><?php echo $value->months; ?> </td>
              <td> <?php echo $value->population ?>  </td>
              <td>  <?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->bcg*1200,2);
              } ?>         </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->opv*1200,2);
              } ?>    </td>
              <td>   <?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->opv1*1200,2);
              } ?>              </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->opv2*1200,2);
              } ?>   </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->opv3*1200,2);
              } ?>   </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->dpt1*1200,2);
              } ?>   </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->dpt2*1200,2);
              } ?>   </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->dpt3*1200,2);
              } ?>   </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->pcv1*1200,2);
              } ?>   </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->pcv2*1200,2);
              } ?>   </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->pcv3*1200,2);
              } ?>   </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->rota1*1200,2);
              } ?>   </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->rota2*1200,2);
              } ?>   </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->measles1*1200,2);
              } ?>  </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->measles2*1200,2);
              } ?>  </td>
              <td><?php if ($value->population<=0) {
                echo 'N/A';
              }else {
                echo round($value->measles3*1200,2);
              } ?>  </td>
              <td> <?php
              if ($value->population<=0 || $value->$A<=0) {
                echo 'N/A';
              }else {
              echo  round(((($value->$A)-($value->$B))*1200)/$value->$A,2);
              }
                ?></td>

              <td><?php
              if ($value->population<=0) {
                echo 'N/A';
              }else {
              echo  round ((($value->$A)-($value->$B)*1200),2);
              }
                ?></td>
            </tr>
          <?php } echo "<tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td></tr>";
          ?>


   </tbody>
</table>
  </div>

</div>
