<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--\\\\\\\ container  start \\\\\\-->
<div class="page-content">
    <div class="row">
        <div class="col-md-4">
            <?php echo $this->session->flashdata('msg');  ?>
            <!--<div class="profile_bg">-->
                <!--<div class="account-status-data">
                    <div class="row">
                        <div class="col-md-4"><img src="<?php /*echo base_url() */?>assets/images/user.jpg" /></div>
                        <div class="col-md-8">
                            <div class="user-identity">
                                <h4><strong> <?php /*echo $user_object['user_fname'].' '.$user_object['user_lname'] ;*/?></strong></h4>

                            </div>
                        </div>
                    </div>
                </div>-->
                <!--<div class="row">
                    <div class="col-md-12">
                        <a href="javascript:void(0);" class="add_user" data-toggle="modal" data-target="#myModal"> <i class="fa fa-key"></i> <span> Change password</span> </a>

                    </div>
                </div>-->
               <!-- </br>
                </br>-->
                <!--                <div>-->
                <!--                    <small class="">Phone</small></br>-->
                <!--                    <abbr title="Phone">--><?php //echo $profile['phone']; ?><!--</abbr>-->
                <!--                    </br>-->
                <!--                    <small class="">Email</small></br>-->
                <!--                    <p> --><?php //echo $profile['email']; ?><!--</p><div class="line"></div>-->
                <!--                    <p class="m-t-sm"> </p>-->
                <!--                </div>-->


            </div>
            <!--/block-web-->

        </div>
        <!--/col-md-4-->
        <div class="col-md-8">
            <div class="block-web full">
                <ul class="nav nav-tabs nav-justified nav_bg">
                    <li class="active"><a href="#edit-profile" data-toggle="tab"><i class="fa fa-pencil"></i> Change User password</a></li>

                </ul>
                <div class="tab-content">

                    <div class="tab-pane animated fadeInRight active" id="edit-profile">
                        <div class="user-profile-content">
                            <?php echo form_open('users/change_password',array('class'=>'form-horizontal','name'=>'ValidationForm'));?>
                            <div class="form-group">
                                <?php
                                //                                    echo "<pre>";
                                //                                    print_r($this->session->all_userdata());
                                //                                    echo "</pre>";
                                echo form_label('Current Password','current_password');
                                echo form_error('current_password','required');
                                echo form_input(['type'=>'password','required','name' => 'current_password', 'id' => 'current_password','class' => 'form-control', 'placeholder' => 'Enter Current Password']);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo form_label('New Password');
                                echo form_error('new_password');
                                echo form_input(['type'=>'password','name' => 'new_password', 'id' => 'new_password','class' => 'form-control', 'placeholder' => 'Enter New Password']);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo form_label('Confirm Password','confirm_password');
                                echo form_error('confirm_password');
                                echo form_input(['type'=>'password','name' => 'confirm_password', 'id' => 'confirm_password','class' => 'form-control', 'placeholder' => 'Confirm New Password']);
                                ?>
                            </div>


                            <?php echo form_submit('submit','Change Password', 'class="fa fa-key btn btn-primary btn-lg"');?>
                            <?php echo form_close();?>

                        </div>
                    </div>

                </div>
                <!--/tab-content-->
            </div>
            <!--/block-web-->
        </div>
        <!--/col-md-8-->
    </div>
    <!--/row-->
</div>
</div>
<!--\\\\\\\ container  end \\\\\\-->

<!-- Modal -->



<script type="text/javascript">

    window.setTimeout(function() {
        $("#alert-message").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 2000);
</script>
<script type="text/javascript">
    window.onload = function () {
        document.getElementById("new_password").onchange = validatePassword;
        document.getElementById("confirm_password").onchange = validatePassword;
        document.getElementById("current_password").onchange = validatePassword;
    }
    function validatePassword(){
        var pass2=document.getElementById("confirm_password").value;
        var pass1=document.getElementById("new_password").value;

        if(pass1!=pass2)
            document.getElementById("confirm_password").setCustomValidity("Password Don't Match New Password");
        else
            document.getElementById("confirm_password").setCustomValidity('');
//empty string means no validation error
    }
</script>