<div class="row">
<div class="col-lg-6">
    <section class="panel default blue_title h2">
        <div class="panel-heading"><?php print_r($email_header->subject)?></div>
        <div class="panel-body">
            <p> <strong class="text-uppercase">
                    From: </strong> <?php $from = $email_header->from;

                    $f = json_decode(json_encode($from), True);
                    print_r($f[0]['personal']);
                    ?> .
                <br>
                <?php
                print_r($email_body);
                ?>
        </div>
    </section>
</div>
    </div>