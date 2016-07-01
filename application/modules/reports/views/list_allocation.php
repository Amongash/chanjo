<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-12">
            <a href="<?php echo site_url('reports/new_allocation');?>" class="btn btn-primary">New Allocations</a>
    </div>
</div>
<div class="row">


    <?php echo $this->session->flashdata('msg'); ?>
    <div class="col-lg-12" style="margin-top: 10px;">
        <div class="table-responsive">
            <table id="table" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Allocation #</th>
                        <th>Alias</th>
                        <td align="center"><b>Action</b></td>

                    </tr>
                </thead>
                <tfoot>
                   <tr>
                        <th>Allocation #</th>
                        <th>Alias</th>
                        <td align="center"><b>Action</b></td>

                    </tr> 
                </tfoot>
            </table>
            <hr>
            </br>


        </div>

    </div>
    <script type="text/javascript">
            var table;
            $(document).ready(function() {
                table = $('#table').DataTable({

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