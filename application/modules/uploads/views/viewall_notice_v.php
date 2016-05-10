<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">Notices</h3>
            </div>
            <div class="porlets-content">
                <div class="adv-table editable-table ">
                    <div class="margin-top-10"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                        <tr>
                            <th>Posted By</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Date Posted</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($notices as $notice){


                        ?>

                        <tr class="">
                            <td><?php echo $notice[0]['user_id']?></td>
                            <td><?php echo $notice[0]['notice_name']?></td>
                            <td><?php echo $notice[0]['notice_name']?></td>
                            <td class="center">super user</td>
                            <td><a class="edit" href="<?php echo site_url('uploads/view_one_notice/'.$notice[0]['id']); ?>">Read</a></td>



                        </tr>
                        <?php
                           } ?>

                        </tbody>
                    </table>
                </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div<!--/row-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Compose New Task</h4>
            </div>
            <div class="modal-body"> content </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
