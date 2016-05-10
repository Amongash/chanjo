<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo $this->session->flashdata('msg'); ?>

<?php
$group = array();
$group[] = "Select One";
foreach ($magroups as $row) {
    $group[$row->id] = $row->name;

}
$level = array();
$level[] = "Select One";
foreach ($malevels as $row) {
    $level[$row->id] = $row->name;
}

$region = array();
$region[] = "Select One";
foreach ($maregion as $row) {
    $region[$row->id] = $row->region_name;
}


$nation = array('Select One', 'Kenya');
$national ="";
$regional ="";

$form = array('class' => 'form-horizontal', 'id' => 'installationForm');
$label = array('class' => 'col-xs-3 control-label');
?>


<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="porlets-content">
                <div class="row">
                    <div class="col-md-10 col-md-offset-2">
                    <?php echo form_open('users/register', $form); ?>
                        <ul class="nav nav-pills">
                            <li class="active"><a href="#tab1" data-toggle="tab">Step 1</a></li>
                            <li><a href="#tab2" data-toggle="tab">Step 2</a></li>
                            <li><a href="#tab3" data-toggle="tab">Step 3</a></li>
                        </ul>

                        <div class="tab-content">
                            <!-- First tab -->
                            
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group">
                                    <?php
                                    echo form_label('Enter First Name', 'f_name', $label);
                                    echo form_error('f_name');
                                    ?>
                                    <div class="col-xs-5">
                                    <?php echo form_input(['name' => 'f_name', 'id' => 'f_name', 'value' => $f_name, 'required' => '', 'class' => 'form-control', 'placeholder' => 'Enter First Name']);?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo form_label('Enter Last Name', 'l_name', $label);
                                    echo form_error('l_name');
                                    ?>
                                    <div class="col-xs-5">
                                     <?php  echo form_input(['name' => 'l_name', 'id' => 'l_name', 'value' => $l_name, 'required' => '', 'class' => 'form-control', 'placeholder' => 'Enter Last Name']);?>
                                    </div>
                                </div>

                                <div class="form-group">
                                     <?php
                                    echo form_label('Enter Phone Number', 'phone', $label);
                                    echo form_error('phone');
                                    ?>
                                    <div class="col-xs-5">
                                     <?php  echo form_input(['name' => 'phone', 'id' => 'phone', 'value' => $phone, 'required' => '', 'class' => 'form-control', 'placeholder' => 'Enter Phone Number']);?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo form_label('Enter Email Address', 'email', $label);
                                    echo form_error('email');
                                    ?>
                                    <div class="col-xs-5">
                                     <?php echo form_input(['name' => 'email', 'id' => 'email', 'value' => $email, 'required' => '', 'class' => 'form-control', 'placeholder' => 'Enter Email']);?>
                                    </div>
                                </div>
                            </div>

                            <!-- Second tab -->
                            <div class="tab-pane" id="tab2">
                             <div class="form-group">
                                     <?php
                                    echo form_label('Enter User Name', 'username', $label);
                                    echo form_error('username');
                                    ?>
                                    <div class="col-xs-5">
                                     <?php echo form_input(['name' => 'username', 'id' => 'username', 'value' => $username, 'required' => '', 'class' => 'form-control', 'placeholder' => 'Enter Username ']);?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo form_label('Enter Password', 'password', $label);
                                    echo form_error('password');
                                    ?>
                                    <div class="col-xs-5">
                                     <?php echo form_password(['name' => 'password', 'id' => 'password', 'class' => 'form-control', 'required' => '', 'placeholder' => 'Enter Password']); ?>
                                     </div>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo form_label('RE-Enter Password', 'password', $label);
                                    echo form_error('password');
                                    ?>
                                    <div class="col-xs-5">
                                     <?php echo form_password(['name' => 'passwordc', 'id' => 'passwordc', 'class' => 'form-control', 'required' => '', 'placeholder' => 'RE-Enter Password']);?>
                                     </div>
                                </div>
                            </div>

                            <!-- Third tab -->
                            <div class="tab-pane" id="tab3">
                                <div class="form-group" id="user_group">
                                     <?php
                                    echo form_label('Enter User Group','user_group', $label);
                                    echo form_error('user_group');
                                    ?>
                                    <div class="col-xs-5">
                                     <?php echo form_dropdown('user_group', $group, $user_group, 'id="user_group" class="form-control"');?>
                                    </div>
                                </div>

                                <div class="form-group" id="user_level">
                                    <?php
                                    echo form_label('Enter Access Level', 'user_level', $label);
                                    echo form_error('user_level');
                                    ?>
                                    <div class="col-xs-5">
                                     <?php echo form_dropdown('user_level', $level, $user_level, 'id="user_level" class="form-control"'); ?>
                                     </div>
                                </div>

                                <div class="form-group" id="base1">
                                    <?php
                                     echo form_label('Enter National Base', 'national', $label);
                                     echo form_error('national');
                                    ?>
                                    <div class="col-xs-5">
                                     <?php echo form_dropdown('national', $nation, set_value($national), 'id="national" class="form-control"');?>
                                    </div>
                                </div>
                                <div class="form-group" id="base2">
                                    <?php
                                    echo form_label('Enter Regional Base ', 'regional', $label);
                                    echo form_error('regional');
                                    ?>
                                    <div class="col-xs-5">
                                     <?php echo form_dropdown('regional', $region, set_value($regional), 'id="regional" class="form-control"');?>
                                    </div>
                                </div>
                                <div class="form-group" id="base3">
                                    <label class="col-xs-3 control-label">Enter County Base</label>
                                    <select name="countyuser" class="form-control" id="countyuser"></select>
                                </div>
                                <div class="form-group" id="base4">
                                    <label class="col-xs-3 control-label">Enter Sub County Base</label>
                                    <select name="subcountyuser" class="form-control" id="subcountyuser"></select>
                                </div>
                                <div class="form-group" id="base5">
                                    <label class="col-xs-3 control-label">Enter Facility Base</label>
                                    <select name="facilityuser" class="form-control" id="facilityuser"></select>

                                </div>
                                
                            </div>

                            <!-- Previous/Next buttons -->
                            <ul class="pager wizard">
                                <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                <li class="next"><a href="javascript: void(0);">Next</a></li>
                            </ul>
                        </div>
                    <?php
                    if (isset($update_id)){
                        echo form_hidden('update_id', $update_id);
                    }
                    echo form_close(); ?>

                    </div>
                </div>
            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-6-->
</div>

<script>
    $(document).ready(function() {

    $('#installationForm').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            // This option will not ignore invisible fields which belong to inactive panels
            excluded: ':disabled',
            fields: {
                f_name: {
                    validators: {
                        notEmpty: {
                            message: 'The First name is required'
                        }
                    }
                },
                l_name: {
                    validators: {
                        notEmpty: {
                            message: 'The Last name is required'
                        }
                    }
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: 'The Phone number is required'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The email address is required'
                        },
                        emailAddress: {
                            message: 'The email address is not valid'
                        }
                    }
                }
            }
        }).bootstrapWizard({
            tabClass: 'nav nav-pills',
            onTabClick: function(tab, navigation, index) {
                return validateTab(index);
            },
            onNext: function(tab, navigation, index) {
                var numTabs    = $('#installationForm').find('.tab-pane').length,
                    isValidTab = validateTab(index - 1);
                if (!isValidTab) {
                    return false;
                }

                if (index === numTabs) {

                    // Uncomment the following line to submit the form using the defaultSubmit() method
                    $('#installationForm').formValidation('defaultSubmit');

                }

                return true;
            },
            onPrevious: function(tab, navigation, index) {
                return validateTab(index + 1);
            },
            onTabShow: function(tab, navigation, index) {
                // Update the label of Next button when we are at the last tab
                var numTabs = $('#installationForm').find('.tab-pane').length;
                $('#installationForm')
                    .find('.next')
                        .removeClass('disabled')    // Enable the Next button
                        .find('a')
                        .html(index === numTabs - 1 ? 'Submit' : 'Next');

            }
        });

    function validateTab(index) {
        var fv   = $('#installationForm').data('formValidation'), // FormValidation instance
            // The current tab
            $tab = $('#installationForm').find('.tab-pane').eq(index);

        // Validate the container
        fv.validateContainer($tab);

        var isValidStep = fv.isValidContainer($tab);
        if (isValidStep === false || isValidStep === null) {
            // Do not jump to the target tab
            return false;
        }

        return true;
    }
});
</script>


<script type="text/javascript">
    $(document).ready(function () {

        //start of user basestation assignment
        $("#base1").hide();
        $("#base2").hide();
        $("#base3").hide();
        $("#base4").hide();
        $("#base5").hide();

        $('#user_level select').change(function () {
            var selLevel = $(this).val();
            console.log(selLevel);

            if (selLevel == '1') {

                // console.log("Detected change... National");
                $("#base1").show();
                $("#base2").hide();
                $("#base3").hide();
                $("#base4").hide();
                $("#base5").hide();

            } else if (selLevel == '2') {
                // console.log("Detected change... Regional");
                $("#base1").show();
                $("#base2").show();
                $("#base3").hide();
                $("#base4").hide();
                $("#base5").hide();
            } else if (selLevel == '3') {
                // console.log("Detected change... County");
                $("#base1").show();
                $("#base2").show();
                $("#base3").show();
                $("#base4").hide();
                $("#base5").hide();


            } else if (selLevel == '4') {
                // console.log("Detected change... Subcounty");
                $("#base1").show();
                $("#base2").show();
                $("#base3").show();
                $("#base4").show();
                $("#base5").hide();
            } else if (selLevel == '5') {
                // console.log("Detected change... Facility");
                $("#base1").show();
                $("#base2").show();
                $("#base3").show();
                $("#base4").show();
                $("#base5").show();
            } else {
                //cleanup function

                $("#base1").hide();
                $("#base2").hide();
                $("#base3").hide();
                $("#base4").hide();
                $("#base5").hide();
            }

        });
        //End of user basestation assignment

    });


    $(document).ready(function () {
        $("#regional").change(function () {
            var regional = $(this).val();
            console.log(regional);
            var request = $.ajax({
                url: "<?php echo base_url(); ?>users/getCountyByRegion/" + regional,
                data: regional,
                type: "POST",
            });
            request.done(function (data) {
                data = JSON.parse(data);
                console.log(data);
                $("#countyuser option").remove();
                $('#countyuser').append("<option value=''>--Select County Base--</option> ");
                $.each(data, function (key, value) {
                    $('#countyuser').append("<option value='" + value.county_id + "'>" + value.county_name + "</option>");
                });
            });
            request.fail(function (jqXHR, textStatus) {
            });
        });
    });

    $(document).ready(function () {
        $("#countyuser").change(function () {
            var countyuser = $(this).val();
            console.log(countyuser);
            var request = $.ajax({
                url: "<?php echo base_url(); ?>users/getSubcountyByCounty/" + countyuser,
                data: countyuser,
                type: "POST",
            });
            request.done(function (data) {
                data = JSON.parse(data);
                console.log(data);
                $("#subcountyuser option").remove();
                $('#subcountyuser').append("<option value=''>--Select Sub County Base--</option> ");
                $.each(data, function (key, value) {
                    $('#subcountyuser').append("<option value='" + value.subcounty_id + "'>" + value.subcounty_name + "</option>");
                });
            });
            request.fail(function (jqXHR, textStatus) {
            });
        });
    });

    $(document).ready(function () {
        $("#subcountyuser").change(function () {
            var subcountyuser = $(this).val();
            console.log(subcountyuser);
            var request = $.ajax({
                url: "<?php echo base_url(); ?>users/getFacilityBySubcounty/" + subcountyuser,
                data: subcountyuser,
                type: "POST",
            });
            request.done(function (data) {
                data = JSON.parse(data);
                console.log(data);
                $("#facilityuser option").remove();
                $('#facilityuser').append("<option value=''>--Select Facility Base--</option> ");
                $.each(data, function (key, value) {
                    $('#facilityuser').append("<option value='" + value.facility_id + "'>" + value.facility_name + "</option>");
                });
            });
            request.fail(function (jqXHR, textStatus) {
            });
        });
    });

</script>

<script type="text/javascript">

    window.setTimeout(function () {
        $("#alert-message").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 5000);

</script>