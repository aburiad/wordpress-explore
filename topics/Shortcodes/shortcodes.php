<?php


/*
==========================================
==========================================


Shortcodes কী?
WordPress-এ shortcode একটি ছোট কোড বা ট্যাগ, যা [shortcode] এর মতো দেখায় এবং সাইটের কন্টেন্টে ডায়নামিক ফাংশনালিটি যোগ করতে ব্যবহার করা হয়। এটি মূলত একটি প্লেসহোল্ডার যা PHP ফাংশনের মাধ্যমে প্রসেস হয় এবং এর মাধ্যমে আপনি জটিল ফিচার সহজেই যোগ করতে পারেন।


Shortcodes-এর ব্যবহার কোথায় হয়?

1. Posts এবং Pages:
[shortcode] সরাসরি পোস্ট বা পেজের কন্টেন্টে ব্যবহার করা যায়।

2. Widgets:
আপনি উইজেটে shortcodes ব্যবহার করতে পারেন, বিশেষত টেক্সট উইজেট বা কাস্টম HTML উইজেটে।

3. Custom Template Files:
PHP ফাইলের ভেতরে do_shortcode() ফাংশন দিয়ে shortcodes প্রসেস করতে পারেন।



১. Simple Shortcode তৈরি করা

// Shortcode রেজিস্টার করা
function my_simple_shortcode() {
    return "Hello, World!";
}
add_shortcode('hello', 'my_simple_shortcode');

ব্যবহার:
পোস্ট, পেজ, বা উইজেটে লিখুন:
[hello]



---------------------------------------------------------
---------------------------------------------------------
২. Shortcode-এ Attributes যোগ করা
Shortcode-এ বিভিন্ন অ্যাট্রিবিউট দিয়ে ডেটা ডাইনামিক করতে পারেন।

উদাহরণ: একটি button Shortcode যা টেক্সট এবং লিংক নেবে।


// Shortcode রেজিস্টার করা
function my_button_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'text' => 'Click Me', // ডিফল্ট টেক্সট
            'url'  => '#',        // ডিফল্ট লিংক
        ),
        $atts
    );

    return '<a href="' . esc_url($atts['url']) . '" class="my-button">' . esc_html($atts['text']) . '</a>';
}
add_shortcode('button', 'my_button_shortcode');

ব্যবহার
[button text="Learn More" url="https://example.com"]



---------------------------------------------------------
---------------------------------------------------------
৩. Content Handling সহ Shortcode
কিছু shortcode এমন হতে পারে যা [shortcode] ... [/shortcode] ফর্ম্যাটে ব্যবহার হয় এবং মাঝখানের কন্টেন্ট প্রসেস করে।

উদাহরণ:
function my_box_shortcode($atts, $content = null) {
    return '<div class="custom-box">' . do_shortcode($content) . '</div>';
}
add_shortcode('box', 'my_box_shortcode');

[box]This is inside the box.[/box]




---------------------------------------------------------
---------------------------------------------------------
Shortcodes ব্যবহারের টিপস
১. Shortcode Widgets-এ ব্যবহার করা:
Widgets-এ shortcode সক্রিয় করতে:
add_filter('widget_text', 'do_shortcode');



২. Template File-এ ব্যবহার করা:
PHP ফাইলের ভেতরে shortcode প্রসেস করতে:

echo do_shortcode('[hello]');


৩. Shortcode Attributes ভ্যালিডেশন:
সব সময় ইউজারের ইনপুট ভ্যালিড করুন।

$atts = shortcode_atts(
    array(
        'url' => '#',
    ),
    $atts
);
$url = esc_url($atts['url']);






==========================================
==========================================

*/










add_shortcode('student', 'wpe_student_msg');
function wpe_student_msg($atts)
{
    shortcode_atts(array(
        'name' => 'name',
        'email' => 'email'
    ), $atts, 'student');
    var_dump($atts);
    return ("<h2>Name is : {$atts['name']} Email: {$atts['email']}</h2>");
}




add_shortcode('post', 'wpe_post_data');

function wpe_post_data()
{
    global $wpdb;

    // get database post what publish and post type post 

    $table_prefix = $wpdb->prefix;
    $table_name = $table_prefix . "posts";
    $posts = $wpdb->get_results("SELECT post_title FROM {$table_name} WHERE post_type = 'post' AND post_status = 'publish'");

    if (count($posts) > 0) {
        echo "<ul>";
        foreach ($posts as $post) {
            echo "<li>.$post->post_title.</li>";
        }
        echo "</ul>";
    }
}
