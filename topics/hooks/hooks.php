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




// ফাংশন যা পোস্ট প্রকাশিত হলে ইমেল পাঠাবে
function send_email_on_publish( $post_id ) {
    // পোস্টের শিরোনাম এবং লেখকের তথ্য সংগ্রহ করা
    $post_title = get_the_title( $post_id );
    $author_id = get_post_field( 'post_author', $post_id );
    $author_name = get_the_author_meta( 'display_name', $author_id );

    // ইমেল রিসিপিয়েন্ট, বিষয় এবং বার্তা সেট করা
    $to = 'test@gmail.com'; // আপনার ইমেল ঠিকানা
    $subject = "নতুন পোস্ট প্রকাশিত হয়েছে: $post_title";
    $message = "একটি নতুন পোস্ট প্রকাশিত হয়েছে:\n\n";
    $message .= "পোস্টের শিরোনাম: $post_title\n";
    $message .= "লেখক: $author_name\n";
    $message .= "লিঙ্ক: " . get_permalink( $post_id );

    // ইমেল পাঠানো
    wp_mail( $to, $subject, $message );
}
add_action( 'publish_post', 'send_email_on_publish' );


// filter
function show_my_name_func($content){
    return $content .= " Add New Name Ahsan ";
}
add_filter('show_my_name','show_my_name_func');


// taxonomy 

function create_custom_taxonomy() {
    register_taxonomy(
        'genre',  // Taxonomy নাম
        'post',   // পোস্ট টাইপের নাম
        array(
            'label' => 'Genres',
            'hierarchical' => true, // এটিকে হায়ারারকিক্যাল করতে পারে
            'show_ui' => true,      // অ্যাডমিন প্যানেলে প্রদর্শিত হবে
            'show_admin_column' => true, // পোস্ট তালিকাতে প্রদর্শন হবে
            'query_var' => true,    // URL-এ এটি কুয়েরি করা যাবে
            'rewrite' => array( 'slug' => 'genre' ), // URL-এর স্লাগ
        )
    );
}
add_action( 'init', 'create_custom_taxonomy' );



// create meta boxes

add_action('add_meta_boxes','add_meta_boxes_function');

function add_meta_boxes_function(){
    add_meta_box( 'author', "Author", 'author_meta_callback');
}
function author_meta_callback($post){
    $authorname = get_post_meta( $post->ID, 'author', true );
    ?>
    <label for="author">Author</label>
    <input type="text" name="author" value="<?php echo esc_attr($authorname)?>"/>
    <?php
}

add_action('save_post','save_meta_author');

function save_meta_author($postId){
    update_post_meta( $postId, 'author', $_POST['author']);
}