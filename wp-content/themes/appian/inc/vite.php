<?php

function theme_vite_manifest() {

    static $manifest = null;

    if ( $manifest ) {
        return $manifest;
    }

    $manifest_path = get_template_directory() . '/public/.vite/manifest.json';

    if ( ! file_exists( $manifest_path ) ) {
        return [];
    }

    $manifest = json_decode(
        file_get_contents( $manifest_path ),
        true
    );

    return $manifest;
}
