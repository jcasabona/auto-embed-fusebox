<?php

function aef_get_media_URL() {
    if ( function_exists( 'powerpress_get_enclosure_data' ) ) {
        $episodeData = powerpress_get_enclosure_data( get_the_ID() );
        if ( ! empty( $episodeData['url'] ) ) {
        return $episodeData['url'];
        }
    }

    return false;
}