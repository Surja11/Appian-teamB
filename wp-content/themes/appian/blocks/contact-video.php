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
<section class="video-section">
    <div class="video-wrapper <?php echo $show_controls ? 'native-controls' : ''; ?>">
        <video 
            id="videoPlayer" 
            class="video-player" 
            preload="metadata"
            poster=""
            <?php echo $show_controls ? 'controls' : ''; ?>
            <?php echo $enable_audio ? '' : 'muted'; ?>
        >
            <source src="<?php echo esc_url($final_video_url); ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        
        <?php if (!$show_controls) : ?>
        <div class="video-controls">
            <button id="playPauseBtn" class="video-control-btn play-btn" aria-label="Play video">
                <span class="play-icon">
                    <?php include get_template_directory() . '/resources/images/icon-play.svg'; ?>
                </span>
                <span class="pause-icon" style="display: none;">
                    <?php include get_template_directory() . '/resources/images/icon-pause.svg'; ?>
                </span>
            </button>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>