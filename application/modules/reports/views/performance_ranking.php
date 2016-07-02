<div class="">
  <div style="min-height: 400px;" id="reports_display">
    <table  class="table table-bordered table-hover table-striped" id="" >
  <thead style="background-color: white">
  <tr>
    <th>Station</th>
    <th>Target Population</th>
    <th><?php echo $vaccine1; ?> Coverage</th>
    <th><?php echo $vaccine2; ?> Coverage</th>
    <th><?php echo $vaccine3; ?> Coverage</th>

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
              <td> </td>
              <td> </td>
              <td> </td>

              <td></td>

              <td></td>



            </tr>
          <?php } echo "<tr>
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
