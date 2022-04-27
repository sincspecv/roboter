<?php

/**
 * Change the Rank Math Metabox Priority
 *
 * @param array $priority Metabox Priority.
 */
add_filter( 'rank_math/metabox/priority', function( $priority ) {
    return 'low';
});

error_log("Rank math code running");
