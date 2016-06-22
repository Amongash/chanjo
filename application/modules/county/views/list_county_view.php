<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-12">
        <!--      <a href="--><?php //echo site_url('county/create');?>
        <!--" class="btn btn-primary">Add County</a>-->
    </div>
</div>
<div class="row">


    <?php echo $this->session->flashdata('msg'); ?>
    <div class="col-lg-12" style="margin-top: 10px;">
        <div class="table-responsive">
            <table id="table" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>County Name</th>
                        <th>Population</th>
                        <th>Population One</th>
                        <th>Women Population</th>
                        <td align="center"><b>Action</b></td>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <hr>
            </br>


        </div>

    </div>
    <script type="text/javascript">
            var table;
            $(document).ready(function() {
                table = $('#table').DataTable({
                    "sDom": '<lf<t>ip>',
                    
                    "serverSide": true, //Feature control DataTables' server-side processing mode.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('county/action_list') ?>",
                        "type": "POST"
                    },
                    "dom": 'Bfrtip',
                    
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
        </script>
    <script type="text/javascript">
        window.setTimeout(function() {
            $("#alert-message").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>