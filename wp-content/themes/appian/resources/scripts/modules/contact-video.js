document.addEventListener('DOMContentLoaded', function() {
    const videoPlayer = document.getElementById('videoPlayer');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const videoWrapper = document.querySelector('.video-wrapper');
    const videoControls = document.querySelector('.video-controls');
    
    if (!videoPlayer) return;
    
    if (!playPauseBtn || !videoControls) {
        return;
    }
    
    let hideControlsTimeout;
    let isMobile = window.matchMedia('(hover: none) and (pointer: coarse)').matches;
    
    function togglePlayPause() {
        if (videoPlayer.paused) {
            videoPlayer.play();
        } else {
            videoPlayer.pause();
        }
    }
    
    function updateButtonState() {
        if (videoPlayer.paused) {
            videoWrapper.classList.remove('playing');
            playPauseBtn.setAttribute('aria-label', 'Play video');
        } else {
            videoWrapper.classList.add('playing');
            playPauseBtn.setAttribute('aria-label', 'Pause video');
        }
    }
    
    function showControls() {
        videoControls.style.opacity = '1';
    }
    
    function hideControls() {
        videoControls.style.opacity = '0';
    }
    
    function hideControlsDelayed() {
        clearTimeout(hideControlsTimeout);
        hideControlsTimeout = setTimeout(() => {
            hideControls();
        }, 3000);
    }
    
    playPauseBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        togglePlayPause();
        if (isMobile) {
            showControls();
            hideControlsDelayed();
        }
    });
    
    videoPlayer.addEventListener('play', updateButtonState);
    videoPlayer.addEventListener('pause', updateButtonState);
    
    if (!isMobile) {
        videoWrapper.addEventListener('mouseenter', function() {
            clearTimeout(hideControlsTimeout);
            showControls();
        });
        
        videoWrapper.addEventListener('mouseleave', function() {
            hideControls();
        });
    } else {
        videoWrapper.addEventListener('touchstart', function(e) {
            if (e.target !== playPauseBtn && !playPauseBtn.contains(e.target)) {
                showControls();
                hideControlsDelayed();
            }
        });
        
        document.addEventListener('touchstart', function(e) {
            if (!videoWrapper.contains(e.target)) {
                hideControls();
            }
        });
    }
    
    videoWrapper.addEventListener('click', function(e) {
        if (e.target === videoPlayer || e.target === videoWrapper) {
            togglePlayPause();
            if (isMobile) {
                showControls();
                hideControlsDelayed();
            }
        }
    });
    
    videoWrapper.addEventListener('keydown', function(e) {
        if (e.key === ' ' || e.key === 'Spacebar') {
            e.preventDefault();
            togglePlayPause();
            showControls();
            if (isMobile) {
                hideControlsDelayed();
            }
        }
    });
    
    videoWrapper.setAttribute('tabindex', '0');
    videoWrapper.setAttribute('role', 'button');
    videoWrapper.setAttribute('aria-label', 'Play video');
});