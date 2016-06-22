<div class="">
  <div style="min-height: 400px;" id="reports_display">
    <table  class="table table-bordered table-hover table-striped" id="" >
  <thead style="background-color: white">
  <tr>
    <th>Station</th>
    <th>Population</th>
    <th>BCG - (Total)</th>
    <th>BCG - (MOS)</th>
    <th>OPV (Total) </th>
    <th>OPV (MOS)</th>
    <th>IPV (Total)</th>
    <th>IPV (MOS)</th>
    <th>ROTA (Total)</th>
    <th>ROTA (MOS)</th>
    <th>MEASLE (Total)</th>
    <th>MEASLE (MOS)</th>
    <th>TT (Total)</th>
    <th>TT (MOS)</th>
    <th>YF (Total)</th>
    <th>YF (MOS)</th>
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
              <td><?php echo $key; ?> </td>
              <td> <?php echo $population[$key]; ?>  </td>
              <td> <?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='BCG') {
                echo $value[$i]->balance;
              }
              }  ?>
                </td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='BCG') {
                  if ($population[$key]==0) {
                    echo 'N/A';

                  }else {
                    echo floor(($value[$i]->balance)/($population[$key]/12));
                  }

              }
              }  ?> </td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='OPV') {
                echo $value[$i]->balance;
              }
              }  ?>
              </td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='OPV') {
                  if ($population[$key]==0) {
                    echo 'N/A';
                  }else {
                    echo floor(($value[$i]->balance)/($population[$key]/12));
                  }

              }
              }  ?></td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='IPV') {
                echo $value[$i]->balance;
              }
              }  ?></td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='IPV') {
                  if ($population[$key]==0) {
                    echo 'N/A';
                  }else {
                    echo floor(($value[$i]->balance)/($population[$key]/12));
                  }

              }
              }  ?></td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='ROTA-Virus') {
                echo $value[$i]->balance;
              }
              }  ?></td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='ROTA-Virus') {
                  if ($population[$key]==0) {
                    echo 'N/A';
                  }else {
                    echo floor(($value[$i]->balance)/($population[$key]/12));
                  }

              }
              }  ?></td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='Measles_Diluent') {
                echo $value[$i]->balance;
              }
              }  ?></td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='Measles_Diluent') {
                  if ($population[$key]==0) {
                    echo 'N/A';
                  }else {
                    echo floor(($value[$i]->balance)/($population[$key]/12));
                  }

              }
              }  ?></td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='TT') {
                echo $value[$i]->balance;
              }
              }  ?></td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='TT') {
                  if ($population[$key]==0) {
                    echo 'N/A';
                  }else {
                    echo floor(($value[$i]->balance)/($population[$key]/12));
                  }

              }
              }  ?></td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='Yellow-Fever') {
                echo $value[$i]->balance;
              }
              }  ?></td>
              <td><?php for ($i=0; $i < sizeof($value); $i++) {
                if ($value[$i]->vaccine_name=='Yellow-Fever') {
                  if ($population[$key]==0) {
                    echo 'N/A';
                  }else {
                    echo floor(($value[$i]->balance)/($population[$key]/12));
                  }

              }
              }  ?></td>
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
