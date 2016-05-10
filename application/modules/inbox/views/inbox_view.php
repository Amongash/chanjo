<div class="row">
    <div class="col-lg-12">
    <?php echo $this->session->flashdata('msg');?>
    <br>
    </div>
  </div>

      
      
       <div class="row">
       
        <div class="col-sm-3 col-lg-2"> <a class="btn btn-danger btn-block btn-compose-email" href="<?php echo site_url('inbox/compose'); ?>">Compose Email</a>
          <ul class="nav nav-pills nav-stacked nav-email">
            <li class="active"> <span class="badge pull-right"><?php print_r($message_count)?></span> <i class="glyphicon glyphicon-inbox"></i> Inbox </li>
            <li><a href="#"><i class="glyphicon glyphicon-star"></i> Starred</a></li>
            <li><a href="#"><i class="glyphicon glyphicon-send"></i> Sent Mail</a></li>
            <li> <a href="#"> <span class="badge pull-right"></span> <i class="glyphicon glyphicon-pencil"></i> Draft </a> </li>
            <li><a href="#"><i class="glyphicon glyphicon-trash"></i> Trash</a></li>
          </ul>
          <div class="mb30"></div>
          
        </div><!-- col-sm-3 -->
        
        <div class="col-sm-9 col-lg-10">
          <div class="block-web">
            <div class="pull-right">
              <div class="btn-group">
                <button title="" data-toggle="tooltip" type="button" class="btn btn-white tooltips" data-original-title="Archive"><i class="glyphicon glyphicon-hdd"></i></button>
                <button title="" data-toggle="tooltip" type="button" class="btn btn-white tooltips" data-original-title="Report Spam"><i class="glyphicon glyphicon-exclamation-sign"></i></button>
                <button title="" data-toggle="tooltip" type="button" class="btn btn-white tooltips" data-original-title="Delete"><i class="glyphicon glyphicon-trash"></i></button>
              </div>
              <div class="btn-group">
                <div class="btn-group nomargin">
                  <button title="" type="button" class="btn btn-white dropdown-toggle tooltips inbox_btn"  data-toggle="dropdown" data-original-title="Move to Folder"> <i class="glyphicon glyphicon-folder-close"></i> <span class="caret"></span> </button>
                  <ul class="dropdown-menu">
                    <li><a href="#"><i class="glyphicon glyphicon-folder-open"></i> Conference</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-folder-open"></i> Newsletter</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-folder-open"></i> Invitations</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-folder-open"></i> Promotions</a></li>
                  </ul>
                </div>
                <div class="btn-group nomargin">
                  <button title="" type="button" class="btn btn-white dropdown-toggle tooltips inbox_btn" data-toggle="dropdown" data-original-title="Label"> <i class="glyphicon glyphicon-tag"></i> <span class="caret"></span> </button>
                  <ul class="dropdown-menu">
                    <li><a href="#"><i class="glyphicon glyphicon-tag"></i> Web</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-tag"></i> Photo</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-tag"></i> Video</a></li>
                  </ul>
                </div>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-white"><i class="glyphicon glyphicon-chevron-left"></i></button>
                <button type="button" class="btn btn-white"><i class="glyphicon glyphicon-chevron-right"></i></button>
              </div>
            </div>
            
            <strong>Inbox</strong>
            <p class="text-muted">Showing <?php print_r($message_count)?> messages</p>
            <!--<div class="table-responsive">
              <table class="table table-email">
                <tbody>

                </tbody>
              </table>-->
            <div class="table-responsive">
              <table class="table table-email">
                <tbody>
                <?php
                foreach ($email as $mail){
                  ?>

                <tr class="read">
                  <a href="">
                  <td><div class="ckbox ckbox-primary">
                      <input type="checkbox" id="checkbox1">
                      <label for="checkbox1"></label>
                    </div></td>
                  <td><a class="btn-sm"  href="<?php echo site_url('inbox/getmail/'.$mail->msgno); ?>">Read</a></td>
                  <td><div class="media">
                      <div class="media-body"> <span class="media-meta pull-right"><?php echo "{$mail->date}";?></span>
                        <h4 class="text-primary"><?php echo "{$mail->from}";?></h4>
                        <small class="text-muted"></small>
                        <p class="email-summary"><strong><?php echo "{$mail->subject}";?></strong> <?php echo "{$mail->subject}";?>  </p>
                      </div>
                    </div></td>
                  </a>
                </tr>

                  <?php
                  }
                ?>

                </tbody>
              </table>
            </div><!-- /table-responsive --
            </div><!-- /table-responsive --> 
          </div><!--/ block-web --> 
        </div><!-- /col-sm-9 --> 
      </div><!--/row-->
       <script type="text/javascript">

         window.setTimeout(function () {
           $("#alert-message").fadeTo(500, 0).slideUp(500, function () {
             $(this).remove();
           });
         }, 5000);

       </script>