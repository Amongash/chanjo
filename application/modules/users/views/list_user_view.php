<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
  <div class="col-lg-12">
    <a href="<?php echo site_url('users/create_user');?>" class="btn btn-primary">Add New User</a>
  </div>
</div>
<div class="row">
<br>
<br>
<?php echo $this->session->flashdata('msg');  ?>
    <div class="col-lg-12" style="margin-top: 10px;">
      <div class="table-responsive">
        <table id="table" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Names</th>
                    <th>Phone</th>
                    <th>Email </th>
                    <th>User Group </th>
                    <th>User Level </th>
                   <td align="center"><b>Edit</b></td> 
                   <td align="center"><b>Delete</b></td>
                </tr>
            </thead>
            <tbody>
              <tfoot>
              <tr>
                    <th>Names</th>
                    <th>Phone</th>
                    <th>Email </th>
                    <th>User Group </th>
                    <th>User Level </th>
                   <td align="center"><b>Edit</b></td> 
                   <td align="center"><b>Delete</b></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
        <hr>
      </br>
    </div>
  </div>
</div>

<script type="text/javascript">
var table;
$(document).ready(function() {
  table = $('#table').DataTable({ 
    
    "serverSide": true, //Feature control DataTables' server-side processing mode.

    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": "<?php echo site_url('users/action_list')?>",
        "type": "POST"
    },
    "responsive": {
          "details": {
              "type": 'column'
          }
      },

      //Set column definition initialisation properties.
      "columnDefs": [{
          "targets": [-1], //last column
          "orderable": true, //set not orderable
      }, ],

  });
});

window.setTimeout(function() {
    $("#alert-message").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);

</script>
