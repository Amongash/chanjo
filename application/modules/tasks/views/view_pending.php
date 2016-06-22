<?php 
         $set_limit    = 0;
         if (is_array($tasks)) :
         	foreach ($tasks as $item): 
        		if( $set_limit == 5 )    break;?>

<ul class="group_sortable1">
    <li>
        	<p><strong><?php echo $item->message; ?></strong> - Lorem Ipsum is simply dummy text . 
            <b>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </b>
            <b>Feb 12, 2014</b>
        </p>
    </li>
</ul>

<?php $set_limit++; 
            endforeach; 
        endif;
        ?>

