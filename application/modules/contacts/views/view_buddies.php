<?php
$ctr = 0;
if (is_array($buddies)):
    foreach ($buddies as $buddy):
?>
        &nbsp;<b><a href="#" class="username" id="friend<?php echo $ctr; ?>"><?php echo $buddy ?></a></b>
        <?php if ($new_message[$ctr] > 0): ?>
            <img src="<?php echo base_url(); ?>/assets/images/envelope.gif" />
        <?php endif; ?>
        <br />
    <?php
            ++$ctr;
        endforeach;
    endif;
    ?>
<script type="text/javascript">
    $(document).ready(function() {
<?php
    for ($ctrjs = 0; $ctrjs < $ctr; $ctrjs++) {
?>
            $('#friend' + <?php echo $ctrjs; ?>).click(function() {
                $('#buddies').hide();
                //start refreshing the chat window
                startrefresh();
                $('#chatroom').show();
                $('#chatmessage').html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif" width="16" height="16" />');
                //add the dude who you're chatting with to session
                $.post("chat/chatbuddy",{
                    username: $("#friend"+<?php echo $ctrjs; ?>).html()
                });

            });
<?php
    }
?>
    });
</script>