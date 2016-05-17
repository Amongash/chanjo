<?php echo $this->session->flashdata('msg');  ?>
<div class="row">

    <div class="col-lg-12 col-sm-12">

     <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-primary state_change dropdown-toggle">Issue stocks directly <span class="caret"></span> </button>
                  <ul class="dropdown-menu">
                    <li> <a href="<?php echo site_url('stock/issue_stock');?>">One Location</a> </li>
                    <li class="divider"></li>
                    <li> <a href="<?php echo site_url('stock/issue_many');?>">Many Locations</a> </li>
                  </ul>
      </div>
    </div>
  </div>
  </br>
  
  <div class="well well-sm"><b>Requests</b></div>
  </br>
<div class="row">
  

<div class="col-lg-12 col-sm-12">
 <div class="panel default blue_title h2">

              <div class="panel-body">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a data-toggle="tab" href="#tab1"><b>Stock Requests to me</b></a></li>
<!--                    <li><a data-toggle="tab" href="#tab2"><b>Requests History</b></a></li>-->
                </ul>
              </div>
<div class="tab-content" id="myTabContent">
  <div id="tab1" class="tab-pane fade in active">
       <form id="list_orders_fm">
  <!--Listing Placed Orders-->


    <table class="table table-bordered table-striped" id="list_orders_tbl">
        <thead>
                <tr><th>Request # </th><th>Request from</th><th>Date Created</th><th align="center">Action</th></tr>
        </thead>

        <tbody>
        <?php $option=2 ; ?>
        <?php foreach ($orders as $order) { 
         $ledger_url = base_url().'order/view_orders/'.$order['user_id'].'/'.$order['transaction_date'].'/'.$option.'/'.$order['id'].'/'.$order['status'];
          $forward_url = base_url().'order/save_forwarded_order/'.$order['id'];
        
         ?>
        
              <tr>
              <td><?php  echo $order['id']?></td>
              <td><?php echo $order['station']?></td>
              <td><?php echo $order['transaction_date']?></td>
          <?php
          if ($user_object['user_level']=='3') {?>
              <td>

                  <a href="<?php  echo $forward_url ?>" class="btn btn-danger btn-xs">Forward Request <i class="fa fa-exchange"></i></a>
              </td>
          <?php }elseif($user_object['user_level']=='1'){?>
              <td>
                  <a href="<?php  echo $ledger_url ?>" class="btn btn-danger btn-xs">View <i class="fa fa-eye"></i></a>
              </td>
         <?php  } else{?>
             <td>
                  <a href="<?php  echo $ledger_url ?>" class="btn btn-danger btn-xs">View <i class="fa fa-eye"></i></a>
                  <a href="<?php  echo $forward_url ?>" class="btn btn-danger btn-xs">Forward Request <i class="fa fa-exchange"></i></a>
              </td>
          <?php }}?>
              </tr>

        </tbody>
        </table>
         <?php echo $this->pagination->create_links(); ?>
    </form>

  </div>

<!--    <div id="tab2" class="tab-pane fade">-->
<!--        <form id="list_orders_fm">-->
            <!--Listing Submitted Requests-->
<!---->
<!---->
<!--            <table class="table table-bordered table-striped" id="list_orders_tbl">-->
<!--                <thead>-->
<!--                <tr><th>Request # </th><th>Date Created</th><th>Status</th><th>Action</th></tr>-->
<!--                </thead>-->
<!---->
<!--                <tbody>-->
<!--                --><?php //$option=2 ; ?>
<!--                --><?php //foreach ($all_orders as $order) {
//                $ledger_url = base_url().'order/view_orders/'.$order['order_by'].'/'.$order['date_created'].'/'.$option.'/'.$order['order_id'].'/'.$order['status_name'];
//                ?>
<!---->
<!--                <tr>-->
<!--                    <td>--><?php // echo $order['order_id']?><!--</td>-->
<!--                    <td>--><?php //echo $order['date_created']?><!--</td>-->
<!--                    <td style="color:red">--><?php //echo $order['status_name']?><!--</td>-->
<!--                    <td><a href="--><?php // echo $ledger_url ?><!--" class="btn btn-danger btn-xs">View <i class="fa fa-eye"></i></a></td>-->
<!--                    --><?php //}?>
<!--                </tr>-->
<!---->
<!--                </tbody>-->
<!--            </table>-->
<!--          --><?php //echo $this->pagination->create_links(); ?>
<!--        </form>-->
<!--    </div>-->

</div>
</div>

</div>
</div>

 <script type="text/javascript">

               window.setTimeout(function() {
                  $("#alert-message").fadeTo(500, 0).slideUp(500, function(){
                      $(this).remove(); 
                  });
              }, 5000);
        </script> 