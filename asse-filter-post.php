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

/**
 * Replace the backend article urls in an oembed html template with the frontend urls
 *
 * @see PEA-5811
 * @see WP_Embed::shortcode()
 *
 * <blockquote class="wp-embedded-content">
 *   <a href="http://192.168.33.10:41801/pmtest/ma-test-2">MA Test</a>
 * </blockquote>
 * <iframe src="http://192.168.33.10:41801/pmtest/ma-test-2/embed"></iframe>
 *
 * @param string $html
 * @param string $url
 * @param string $attr
 * @param int $postId
 * @return string
 */
function replaceEmbedHtmlUrl($html, $url, $attr, $postId)
{
    // we cannot modify the urls for the backend because it does not know the frontend
    if ('backend' === getenv('WP_LAYER')) {
        return $html;
    }

	if(!defined('ASSE_REPLACE_BACKEND_URL')) {
		return;
	}
	
	$originUrl = getenv("WP_ORIGIN");
	
    // replace backend urls
    $html = str_replace(ASSE_REPLACE_BACKEND_URL, $originUrl, $html);

    return $html;
}

add_filter('embed_oembed_html', 'replaceEmbedHtmlUrl', 10, 4);
