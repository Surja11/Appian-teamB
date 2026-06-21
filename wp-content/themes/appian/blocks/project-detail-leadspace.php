<?php
$project_detail = get_field('project_detail_leadspace');
$project_detail_text = $project_detail['project_detail_text'];
$project_eyebrow = $project_detail_text['project_detail_eyebrow'];
$project_title = $project_detail_text['project_title'];
$project_description = $project_detail_text['project_description'];
$project_quote = $project_detail_text['project_quote'];
$project_image = $project_detail['project_detail_image'];

if(empty($project_detail)){
    return;
}

if(empty($project_detail_text) && empty($project_image)){
    return;
}

if (!empty($project_eyebrow)||!empty($project_title)||!empty($project_description)||!empty($project_quote)||!empty($proejct_image)):

?>

<section class="project-detail-leadspace d-flex flex-column flex-lg-row">

    <div class="project-detail-leadspace__text-container d-flex justify-content-center align-items-center w-lg-50">
        <div class="project-detail-leadspace__text-content  ps-7 pe-7 ps-lg-10 pe-lg-10 d-flex flex-column gap-6 gap-lg-8">
            
        <?php if($project_eyebrow):?>
            <h1 class="subheading-3 mb-0">
                <?php echo esc_html($project_eyebrow)?>
            </h1>
        <?php endif ?>

        <?php if($project_title):?>
            <h2 class="mb-0">
                <?php echo esc_html($project_title)?>
            </h2>
        <?php endif?>


        <?php if($project_description):?>
            <div class="body body-large mb-0">
             <?php echo wp_kses_post($project_description)?>
        </div>
        <?php endif?>


        <?php if($project_quote):?>
            <p class="body body-small">
                <?php echo esc_html($project_quote)?>
            </p>
        <?php endif?>
        </div>
    </div>

    <div class="project-detail-leadspace__img-part w-lg-50">
        <?php if(!empty($project_image)):?>
        <img src="<?php 
            echo esc_url($project_image['url'])
        ?>" alt="<?php echo esc_attr($project_image['alt'])?>"/>
        <?php endif?>
    </div>


</section>
<?php endif?>