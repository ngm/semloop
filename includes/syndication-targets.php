<?php

// Callback for micropub_syndicate-to filter hook provided by the Micropub plugin.
// Adds in a syndication target for the social.coop mastodon instance.
function add_mastodon_syndication_target($synd_urls, $user_id)
{
    $masto_target['uid'] = "social_coop";
    $masto_target['name'] = "social.coop";
    $synd_urls[] = $masto_target;
    return $synd_urls;
}
add_filter("micropub_syndicate-to", "add_mastodon_syndication_target", 10, 2);

// Callback for the micropub_syndication filter hook provided by the Micropub plugin.
// Syndicates posts to the social.coop mastodon instance.
function syndicate_to_mastodon($ID, $syndicate_to)
{
    $post = get_post($ID);
    $message = $post->post_content;
    foreach ($syndicate_to as $syndication_target_uid) {
        if ($syndication_target_uid === 'social_coop') {
            $instance = get_option( 'autopostToMastodon-instance' );
            $access_token = get_option('autopostToMastodon-token');
            $mode = get_option( 'autopostToMastodon-mode', 'public' );
            $client = new Client($instance, $access_token);
            $toot = $client->postStatus($message, $mode);
        }
    }
}
add_filter("micropub_syndication", "syndicate_to_mastodon", 10, 2);
