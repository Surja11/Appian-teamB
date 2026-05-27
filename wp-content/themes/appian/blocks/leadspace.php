<?php
    $content = get_field('leadspace');
    $title   = $content['title'] ?? false;
    if(isset($title)):?>
        <h1 class="leadspace bg-primary"><?php echo esc_html($title);?></h1>
<?php
    endif;    ?>
    
    <section>
    
    <h1>Thisis leadspace</h1>
    </section>
