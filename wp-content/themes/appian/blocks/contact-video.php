<?php
$video_source = get_field('video_source') ?: 'upload';
$video_file = get_field('video_file');
$video_url = get_field('video_url');
$show_controls = get_field('show_controls');
$enable_audio = get_field('enable_audio');

$final_video_url = '';
if ($video_source === 'upload' && $video_file) {
    $final_video_url = $video_file['url'];
} elseif ($video_source === 'url' && $video_url) {
    $final_video_url = $video_url;
}
?>

<?php if ($final_video_url) : ?>
<section class="video-section position-relative w-100 overflow-hidden mx-auto">
    <div class="video-wrapper <?php echo $show_controls ? 'native-controls' : ''; ?> position-relative w-100 overflow-hidden">
        <video 
            id="videoPlayer" 
            class="video-player w-100 h-100 d-block" 
            preload="metadata"
            poster=""
            <?php echo $show_controls ? 'controls' : ''; ?>
            <?php echo $enable_audio ? '' : 'muted'; ?>
        >
            <source src="<?php echo esc_url($final_video_url); ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        
        <?php if (!$show_controls) : ?>
        <div class="video-controls position-absolute top-50 start-50 translate-middle">
            <button id="playPauseBtn" class="video-control-btn play-btn d-flex align-items-center justify-content-center position-relative border-0 rounded-circle" aria-label="Play video">
                <span class="play-icon d-flex align-items-center justify-content-center position-absolute top-50 start-50 translate-middle">
                    <?php include get_template_directory() . '/resources/images/icon-play.svg'; ?>
                </span>
                <span class="pause-icon d-flex align-items-center justify-content-center position-absolute top-50 start-50 translate-middle d-none">
                    <?php include get_template_directory() . '/resources/images/icon-pause.svg'; ?>
                </span>
            </button>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>