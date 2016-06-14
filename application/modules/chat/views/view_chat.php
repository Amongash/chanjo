<script type="text/javascript">
    $(document).ready(function() {
        //the x button in the right section of the chat window
        $('#closechat').click(function() {
            $('#chatroom').hide();
            //stop refreshing the chat
            stoprefresh();
        });
    });
</script>
<div class="headerchat"><div class="buddycontainer">&nbsp;<?php echo $buddy; ?></div>
    <div class="closecontainer"><a class="close-down" href="#" id="closechat"><i class="fa fa-times"></i></a>&nbsp;</div>
    <br class="breaker" />
</div>
<div align="right"><span class="gray"><?php echo date("F d, Y");?></span></div>

<?php
if (is_array($chat)) :
    foreach ($chat as $item): ?>
        <div class="conversation">
        <b><span class="username"><?php echo $item['username']; ?></span></b>
        <span class="gray">&nbsp;<?php echo $item['time'];?></span>
        <br /><?php echo $item['message']; ?>
        </div>
    <?php endforeach; ?>
<?php
endif;
?>
