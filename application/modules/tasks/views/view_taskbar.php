      <div class="top_pointer"></div>
        <?php 
         $set_limit    = 0;
         if (is_array($tasks)) :?>
         <li>
                <p class="number">You have <?php echo count($tasks); ?> pending tasks</p>
            </li>
        <?php  foreach ($tasks as $item): 
        if( $set_limit == 5 )    break;?>
            
                <li>
                    <a href="task.html" class="task">
                        <div class="red_status task_height" style="width:100%;"></div>
                        <div class="task_head"> <span class="pull-left"> <?php echo $item->message; ?> </span> <span class="pull-right green_label">Pending</span> </div>
                        <div class="task_detail"> <?php //echo $item['message']; ?> </div>
                    </a>
                </li>
            <?php $set_limit++; 
            endforeach; ?>
        <?php
        endif;
        ?>
            <li>  <a href="<?php echo site_url('tasks/all'); ?>" class="pull-right">View All</a> </span> </li>
        </ul>
    </li>
 

