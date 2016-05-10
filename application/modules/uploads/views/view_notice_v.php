<?php var_dump($email);?>
<div class="row">
    <div class="col-lg-6">
        <section class="panel default blue_title h2">
            <div class="panel-heading"><?php echo $notice[0]['notice_name']?></div>
            <div class="panel-body">
                <div class="border">
                    <blockquote>
                        <p><?php echo $notice[0]['notice_description']?></p>
                        <small class="small_size">Someone famous in <cite title="Source Title"><?php echo $notice[0]['user_id']?></cite></small> </blockquote>
                </div>
                <a class="edit" href="<?php echo site_url('uploads/mark_as_read/'.$notice[0]['id']); ?>">Mark as Read</a>
            </div>
        </section>
    </div>
</div>