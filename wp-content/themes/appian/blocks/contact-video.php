<?php
$video_source = get_field('video_source') ?: 'upload';
$video_file = get_field('video_file');
$video_url = get_field('video_url');
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
    <div class="video-thumbnail-wrapper position-relative w-100 overflow-hidden cursor-pointer" 
         data-video-url="<?php echo esc_attr($final_video_url); ?>"
         data-enable-audio="<?php echo $enable_audio ? 'true' : 'false'; ?>"
         tabindex="0"
         role="button"
         aria-label="Open video in popup">
        <div class="video-thumbnail w-100 h-100 d-block position-relative">
            <video class="video-poster w-100 h-100 d-block" preload="metadata" muted>
                <source src="<?php echo esc_url($final_video_url); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="video-overlay position-absolute top-0 start-0 w-100 h-100"></div>
        </div>
        
        <div class="video-controls position-absolute top-50 start-50 translate-middle">
            <button class="video-control-btn play-btn d-flex align-items-center justify-content-center position-relative border-0 rounded-circle" aria-label="Play video">
                <span class="play-icon d-flex align-items-center justify-content-center position-absolute top-50 start-50 translate-middle">
                    <?php include get_template_directory() . '/resources/images/icon-play.svg'; ?>
                </span>
            </button>
        </div>
    </div>
</section>

<div class="video-modal-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center overflow-hidden pe-auto d-none" id="video-modal-overlay">

    <div class="video-modal container overflow-hidden d-flex flex-column align-items-center justify-content-center">
        
        <div class="video-modal__content position-relative w-100 h-100 d-flex align-items-center justify-content-center">
            <button class="video-modal__close position-absolute border-0 cursor-pointer d-flex align-items-center justify-content-center bg-transparent p-0 pe-auto" aria-label="Close video modal">
                <?php include get_template_directory() . '/resources/images/icon-close.svg'; ?>
            </button>
            
            <video 
                id="modalVideoPlayer" 
                class="modal-video-player w-100 h-100 d-block" 
                preload="metadata"
                controls
                controlslist="nodownload"
                data-enable-audio="true"
            >
                <source src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</div>

<?php endif; ?>