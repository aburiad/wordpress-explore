<?php

do_action('prefix_display_custom_msg');

function prefix_display_custom_my_mssage()
{
    echo "Hello This is custom override message";
}

add_action('prefix_display_custom_msg', 'prefix_display_custom_my_mssage');



// let's create a custom action hooks

add_action( 'my_custom_action', 'my_custom_action_function',20);
function my_custom_action_function(){
    echo "<h2>Hello i am form custom action</h2>";
}

add_action('my_custom_action_body','my_custom_action_body_function',20);
function my_custom_action_body_function(){
    echo "<div class='body-layout'>Body Layout</div>";
}

add_action('my_custom_action_footer','my_custom_action_footer_function',20);
function my_custom_action_footer_function(){
    echo "<div class='footer-layout'>Footer Layout</div>";
}

add_action('my_custom_title','my_custom_title_function',20,2);
function my_custom_title_function($title,$content){
    echo "<h2> title is $title and content is $content </h2>";
}

function notify_on_publish( $post_id,$postObj ) {
    $post_title = get_the_title( $post_id );
    $author_id = get_post_field( 'post_author', $post_id );
    $author_name = get_the_author_meta( 'display_name', $author_id );
    $message = "নতুন পোস্ট প্রকাশিত হয়েছে: '$post_title' (লেখক: $author_name) ";

    update_option( 'new_post_hook', array('info'=>$message,'obj'=>$postObj) );
}
add_action( 'publish_post', 'notify_on_publish',20,2 );
