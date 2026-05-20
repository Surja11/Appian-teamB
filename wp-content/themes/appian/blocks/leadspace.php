<?php
    $content = get_field('leadspace');
    $title   = $content['title'] ?? false;
    if(isset($title)):?>
        <h1 class="leadspace"><?php echo esc_html($title);?></h1>
<?php
    endif;    
