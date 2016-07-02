<div class="row" id="msg">
  <?php
  
  if ($message!='') {
    echo '<div class="alert alert-success alert-dismissable" style="text-align:center;"> '.$message.'
  <button type="button" class=" close" data-dismiss="alert" aria-hidden="true">×</button>
  ', '</div>';
  unset($message);
  }
  					?>
</div>
<div class="row" id="edit_population">


  <div  class="form-group col-md-12">
    <label for="station">Station</label>
    <input type="station" class="form-control" id="station" placeholder="" value="<?php echo $station; ?>" readonly="">
  </div>
  <div class="form-group col-md-12">
    <label for="exampleInputPassword1">Population</label>
    <input type="population" class="form-control" id="population" placeholder="" value="<?php echo $population; ?>">
  </div>

  <button type="submit" class="btn btn-success" id="edit" name="edit" style="margin-left:2%;">Edit</button>


</div>

<script type="text/javascript">

var url="<?php echo base_url(); ?>";

$( "#edit" ).click(function() {

  //var station=$('#station').val();
  var population=$('#population').val();
  console.log(population);

  ajax_fill_data('reports/edit_population/'+population,"#edit_population");

});

function ajax_fill_data(function_url,div){
    var function_url =url+function_url;
    var loading_icon=url+"assets/images/loader.gif";
    $.ajax({
    type: "POST",
    url: function_url,
    beforeSend: function() {
    $(div).html("<img style='margin:10% 50% 0 50%;' src="+loading_icon+">");
    },
    success: function(msg) {
    $(div).html(msg);
    }
    });
    }

    </script>
