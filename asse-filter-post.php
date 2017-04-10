<?php

// @codingStandardsIgnoreFile

/**
 * Replace WP_HOME url in post content with an empty string
 *
 * @param array $data
 * @return mixed
 */
function replaceContentUrls($data)
{
    //replace all WP_HOME matches with an empty string
    $newContent = str_replace(WP_HOME, '', $data['post_content']);

    //assign it back to post
    $data['post_content'] = $newContent;

    // do something with the post data
    return $data;
}
add_filter('wp_insert_post_data', 'replaceContentUrls', 99, 1);
