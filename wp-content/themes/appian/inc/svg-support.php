<?php



// Registering SVG as an allowed upload mime type.
add_filter( 'upload_mimes', function ( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
} );

// Preventing WordPress's file-type check from rejecting SVGs.
add_filter( 'wp_check_filetype_and_ext', function ( $data, $file, $filename, $mimes ) {
    if ( ! $data['type'] ) {
        $ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
        if ( $ext === 'svg' || $ext === 'svgz' ) {
            $data['type'] = 'image/svg+xml';
            $data['ext']  = $ext;
        }
    }
    return $data;
}, 10, 4 );

// Sanitizing SVG content on upload — remove scripts and event handlers.
add_filter( 'wp_handle_upload_prefilter', function ( $file ) {
    if ( $file['type'] !== 'image/svg+xml' ) {
        return $file;
    }

    $svg = file_get_contents( $file['tmp_name'] );

    if ( $svg === false ) {
        return $file;
    }

    $svg = preg_replace( '/<script[\s\S]*?<\/script>/i', '', $svg );

    $svg = preg_replace( '/\bon\w+\s*=\s*(["\'])[^"\']*\1/i', '', $svg );

    $svg = preg_replace( '/\bhref\s*=\s*(["\'])javascript:[^"\']*\1/i', '', $svg );

    file_put_contents( $file['tmp_name'], $svg );

    return $file;
} );

// Showing SVG thumbnails in the media library.
add_action( 'admin_head', function () {
    echo '<style>
        .attachment-266x266, .thumbnail img {
            width: 100% !important;
            height: auto !important;
        }
        img[src$=".svg"], img[src$=".svgz"] {
            width: 100px;
            height: auto;
        }
    </style>';
} );
