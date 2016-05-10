<?php defined('BASEPATH') OR exit('No direct script access allowed');?>



<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <?php echo $this->session->flashdata('msg');  ?>
        <?php //echo validation_errors('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>',' </b></div>');?>

        <?php echo form_open('uploads/upload_notice',array('class'=>'form-horizontal'));?>
        <div class="form-group">
            <?php
            echo form_label('Notice Name','notice_name');
            echo form_error('notice_name');
            echo form_input(['name' => 'notice_name', 'id' => 'notice_name', 'class' => 'form-control', 'placeholder' => 'Enter Notice Name']);
            ?>
        </div>
        <div class="form-group">
            <?php
            echo form_label('Notice Description','notice_description');
            echo form_error('policy_description');
            echo form_input(['type'=>'textbox','col'=>'20','name' => 'notice_description', 'id' => 'notice_description',  'class' => 'form-control', 'placeholder' => 'Notice']);
            ?>
        </div>

        <div >
            <button class="btn btn-lg btn-danger btn-block" name="submit" type="submit">Submit notice</button>
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
