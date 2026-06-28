<?php
$eyebrow_text = get_field('eyebrow_text');
$heading_main = get_field('heading_main');
$heading_sub  = get_field('heading_sub');
$video = get_field('video');
$video_url    = $video ? esc_url($video['url']) : '';
$video_poster = get_field('poster');

?>

<?php if ($eyebrow_text || $heading_main || $heading_sub || $video_url) : ?>
    <section class="home-leadspace w-100 overflow-hidden">

        <div class="home-leadspace__outer-ellipse">
            <span class="home-leadspace__scroll-ellipse"></span>

            <div class="home-leadspace__inner-ellipse">


                <?php if ($video_url) : ?>
                    <div class="video-container">
                        <video
                            autoplay
                            muted
                            loop
                            playsinline
                            preload="auto"
                            poster="<?php echo $video_poster ? esc_url($video_poster['url']) : ''; ?>"
                            class="home-leadspace__video"
                            disablepictureinpicture
                            disableremoteplayback>
                            <source src="<?php echo $video_url; ?>" type="video/mp4">
                        </video>
                    </div>
                <?php endif; ?>

                <div class="home-leadspace__overlay position-absolute inset-0"></div>


                <div class="text-container">
                    <div class="home-leadspace__text-content d-flex flex-column">
                        <?php if ($eyebrow_text) : ?>
                            <div class="home-leadspace__eyebrow">
                                <span class="body body-small-all text-capitalize">
                                    <?php echo esc_html($eyebrow_text); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        <div class="home-leadspace__text-body">
                            <?php if ($heading_sub) : ?>
                                <h1 class="h3 m-0">
                                    <?php echo esc_html($heading_sub); ?>
                                </h1>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>
<?php endif; ?>