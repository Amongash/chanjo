<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-12">
        <!--      <a href="--><?php //echo site_url('subcounty/create');?>
        <!--" class="btn btn-primary">Add Sub County</a>-->
    </div>
</div>
<div class="row">


    <?php echo $this->session->flashdata('msg'); ?>
    <div class="col-lg-12" style="margin-top: 10px;">
        <div class="table-responsive">
            <table id="table" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Sub County Name</th>
                        <th>Estimated Total Population</th>
                        <th>Estimated Population &lt; 1yr</th>
                        <th>Estimated Women Population</th>
                        <td align="center"><b>Action</b></td>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <hr>
            </br>

        </div>
        <script type="text/javascript">
            var table;
            $(document).ready(function() {
                table = $('#table').DataTable({
                    "sDom": '<lf<t>ip>',
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('subcounty/action_list') ?>",
                        "type": "POST"
                    },
                    "dom": 'Bfrtip',
                    "buttons": [
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5',
                    ],
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