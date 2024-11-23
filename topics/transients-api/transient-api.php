<?php

/*

WordPress Transients API দিয়ে ডেটা সংরক্ষণ করা (Transients API for Storing Data)
WordPress-এর Transients API হল একটি সিস্টেম যেখানে অস্থায়ী ডেটা (temporary data) নির্দিষ্ট সময়ের জন্য ডাটাবেজ বা ক্যাশ মেমোরিতে সংরক্ষণ করা হয়। এটি এমন ডেটার জন্য ব্যবহার হয় যা বারবার গণনা বা প্রসেস না করে সাময়িকভাবে সংরক্ষণ করা দরকার, যেমন API থেকে আনা ডেটা, ওয়েবসাইটের স্ট্যাটিসটিক্স, অথবা কাস্টম ক্যাশিং।

** কেন Transients API ব্যবহার করবেন? **
1. পেজ লোড টাইম কমায়: বারবার ডেটা প্রসেস না করে সেভ করা ডেটা ব্যবহার করা যায়।
2. ডেটার মেয়াদ থাকে: নির্দিষ্ট সময় পর পুরনো ডেটা স্বয়ংক্রিয়ভাবে মুছে যায়।
3. সহজ কোডিং সিস্টেম: কমপ্লেক্স ক্যাশিং এর চেয়ে সহজে কাজ করে।

Transients API-এর প্রধান ফাংশনগুলো
-> set_transient(): ডেটা সংরক্ষণ করা।
-> get_transient(): সংরক্ষিত ডেটা রিট্রিভ করা।
-> delete_transient(): ডেটা মুছে ফেলা।


------------------------------------------------------------------
------------------------------------------------------------------

১. ডেটা সংরক্ষণ করা (set_transient)
set_transient() ফাংশন ব্যবহার করে আপনি ডেটা ক্যাশ করতে পারেন।

set_transient( $transient_name, $value, $expiration );

প্যারামিটার:
1. $transient_name: ট্রান্সিয়েন্টের নাম (ইউনিক হওয়া দরকার)।
2. $value: সংরক্ষণ করতে চাওয়া ডেটা (যেকোনো ডেটা, যেমন অ্যারে বা অবজেক্ট)।
3. $expiration: মেয়াদ শেষ হওয়ার সময় (সেকেন্ডে)।

উদাহরণ:
set_transient('latest_posts', $latest_posts_array, 3600); // ১ ঘন্টার জন্য ক্যাশ

------------------------------------------------------------------
------------------------------------------------------------------


------------------------------------------------------------------
------------------------------------------------------------------
২. ডেটা রিট্রিভ করা (get_transient)
get_transient() ফাংশনের মাধ্যমে ট্রান্সিয়েন্ট থেকে ডেটা রিট্রিভ করা যায়।

$value = get_transient( $transient_name );

উদাহরণ
$latest_posts = get_transient('latest_posts');
if ( false === $latest_posts ) {
    // ডেটা ক্যাশে নেই, তাই নতুন করে ফেচ করতে হবে
    $latest_posts = wp_get_recent_posts(array('numberposts' => 5));
    set_transient('latest_posts', $latest_posts, 3600); // ক্যাশে সেভ করা
}

------------------------------------------------------------------
------------------------------------------------------------------



------------------------------------------------------------------
------------------------------------------------------------------

৩. ডেটা মুছে ফেলা (delete_transient)
delete_transient() ব্যবহার করে ট্রান্সিয়েন্ট ডেটা মুছে ফেলা যায়।

delete_transient( $transient_name );

উদাহরণ
delete_transient('latest_posts'); // পুরনো ডেটা মুছে ফেলা
------------------------------------------------------------------
------------------------------------------------------------------


*/

/*
==========================================
==========================================
Transients API-এর ব্যবহারিক উদাহরণ

ধরা যাক, একটি ওয়েবসাইটে সর্বশেষ পোস্টগুলো দেখানোর জন্য API থেকে ডেটা আনা হয়। বারবার API কল করলে ওয়েবসাইট ধীর হতে পারে। আমরা Transients API ব্যবহার করে ডেটা ক্যাশ করতে পারি।


function fetch_latest_posts() {
   $cached_posts = get_transient('latest_posts');

   if (false === $cached_posts) {
       // ক্যাশে কিছু নেই, তাই নতুন করে ডেটা আনুন
       $cached_posts = wp_get_recent_posts(array('numberposts' => 5));
       set_transient('latest_posts', $cached_posts, 3600); // ১ ঘণ্টার জন্য ক্যাশ
   }

   return $cached_posts;
}

// ব্যবহার
$posts = fetch_latest_posts();
foreach ($posts as $post) {
   echo $post['post_title'] . '<br>';
}

সতর্কতা
-> set_transient() ফাংশন ব্যবহারে ট্রান্সিয়েন্টের নাম ইউনিক রাখতে হবে।
-> মেয়াদ শেষ হওয়ার পরে ট্রান্সিয়েন্ট স্বয়ংক্রিয়ভাবে মুছে যায়।
-> বড় ডেটার জন্য ব্যবহার করলে সার্ভারের পারফরম্যান্সে প্রভাব পড়তে পারে।

==========================================
==========================================

*/


/**
==========================================
==========================================
বড় ডেটার জন্য Transients API ব্যবহার করলে সার্ভারের পারফরম্যান্সে প্রভাব পড়তে পারে কারণ:

ডেটাবেজ স্টোরেজ:

Transients API ডেটা সংরক্ষণ করার জন্য ডাটাবেজ ব্যবহার করে যদি কোনো persistent object cache (যেমন Memcached বা Redis) ইনস্টল করা না থাকে।
বড় ডেটা (যেমন বড় অ্যারে বা অবজেক্ট) ডাটাবেজে বারবার লেখা এবং পড়ার ফলে ডাটাবেজ লোড বেড়ে যেতে পারে।
ক্যাশ ইনভ্যালিডেশন সমস্যা:

বড় ডেটার ক্যাশ মেয়াদ শেষ হওয়ার পরে নতুন ডেটা ক্যাশ করতে আরও বেশি সময় লাগতে পারে, যা সার্ভারের লোড বাড়ায়।
Memory Usage:

যদি persistent object cache ব্যবহার করা হয়, বড় ডেটা মেমোরিতে অনেক জায়গা দখল করে, যা সার্ভারের RAM ব্যবহার বাড়িয়ে দিতে পারে।
RAM শেষ হয়ে গেলে fallback হিসেবে ডাটাবেজ ব্যবহার হয়, যা পারফরম্যান্স কমিয়ে দেয়।
Concurrency Issues:

একই সময়ে অনেক ব্যবহারকারী বড় ডেটা প্রসেস করলে Transients API ডেটার ওপর রিড/রাইট কনফ্লিক্ট তৈরি করতে পারে।

==========================================
==========================================

সমাধান:
1. বড় ডেটা ভেঙে সংরক্ষণ করুন:
-> বড় ডেটাকে ছোট ছোট অংশে ভাগ করে আলাদা ট্রান্সিয়েন্টে সংরক্ষণ করুন।

set_transient('part_1_data', $part1, 3600);
set_transient('part_2_data', $part2, 3600);





2. Persistent Object Cache ব্যবহার করুন:
Memcached বা Redis ব্যবহার করলে ডেটা ডাটাবেজে না গিয়ে মেমোরিতে সঞ্চিত হয়, যা দ্রুত কাজ করে।

3. ডেটা কম্প্রেশন করুন:
বড় ডেটা সংরক্ষণের আগে কমপ্রেস করে রাখুন এবং রিট্রিভ করার পরে আনকমপ্রেস করুন।

$data = gzcompress(serialize($large_data));
set_transient('compressed_data', $data, 3600);

// রিট্রিভ করার সময়
$retrieved_data = unserialize(gzuncompress(get_transient('compressed_data')));



 */










/*

 উদাহরণ: API ডেটা আপডেট করা
আপনার সাইটে আবহাওয়ার তথ্য (Weather Data) API থেকে নিয়ে ক্যাশিং করছেন। নতুন ডেটা প্রয়োজন হলে ডেটা আপডেট করতে হবে।

function update_weather_data_transient() {
    // পুরোনো ট্রান্সিয়েন্ট ডেটা মুছে ফেলুন।
    delete_transient( 'weather_data' );

    // API থেকে নতুন ডেটা সংগ্রহ করুন।
    $response = wp_remote_get( 'https://api.example.com/weather' );

    if ( is_wp_error( $response ) ) {
        return 'Could not fetch weather data.';
    }

    $weather_data = wp_remote_retrieve_body( $response );

    // নতুন ডেটা ১ ঘণ্টার জন্য ট্রান্সিয়েন্টে সেভ করুন।
    set_transient( 'weather_data', $weather_data, HOUR_IN_SECONDS );

    return $weather_data;
}




function display_weather_data() {
    // প্রথমে ট্রান্সিয়েন্ট থেকে ডেটা চেক করুন।
    $weather = get_transient( 'weather_data' );

    if ( false === $weather ) {
        // যদি ডেটা না থাকে বা মুছে ফেলা হয়, নতুন ডেটা আনুন।
        $weather = update_weather_data_transient();
    }

    echo 'Current Weather: ' . $weather;
}

// Shortcode দিয়ে পেজে দেখানোর জন্য।
add_shortcode( 'show_weather', 'display_weather_data' );


*/




/*
// real example with transient wp query 

// using transient api 

   $transient_key = 'all_posts_data';

   // প্রথমে ট্রান্সিয়েন্ট থেকে ডেটা চেক করুন।
   $posts_data = get_transient($transient_key);

   if (false === $posts_data) {
      // ট্রান্সিয়েন্টে ডেটা না থাকলে, নতুন ডেটা সংগ্রহ করুন।
      $condition = array(
         'post_type'      => 'post',
         'posts_per_page' => -1,
      );
      $query = new WP_Query($condition);

      if ($query->have_posts()) {
         $posts_data = ''; // পোস্ট ডেটা জমা রাখার জন্য ভ্যারিয়েবল।

         while ($query->have_posts()) {
            $query->the_post();
            $posts_data .= get_the_title() . "<br>"; // পোস্টের শিরোনাম জমা।
         }

         // নতুন ডেটা ট্রান্সিয়েন্টে সেভ করুন (১ ঘণ্টার জন্য)।
         set_transient($transient_key, $posts_data, HOUR_IN_SECONDS);

         // রিসেট পোস্ট ডেটা।
         wp_reset_postdata();
      } else {
         $posts_data = "No post found";
      }
   }

   // শেষ ধাপে ট্রান্সিয়েন্ট বা ডাটাবেজ থেকে ডেটা দেখান।
   echo $posts_data;


*/
