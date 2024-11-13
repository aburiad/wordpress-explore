<?php

function manage_column_learn($column)
{
    print_r($column);
    $column['id'] = __('Post Id', 'learn');
    $column['thumbnail'] = __('Thumbnail', 'learn');
    $column['wordcount'] = __('Word Count', 'learn');
    return $column;
}

add_filter('manage_posts_columns', 'manage_column_learn');
add_filter('manage_pages_columns', 'manage_column_learn');

function populate_column_data($column, $post_id)
{
    if ('id' == $column) {
        echo $post_id;
    } elseif ('thumbnail' == $column) {
        $thumbnail = get_the_post_thumbnail($post_id, array(80, 80));
        echo $thumbnail;
    } elseif ('wordcount' == $column) {
        $post = get_post($post_id);
        $content = $post->post_content;
        echo str_word_count($content);
    }
}

add_action('manage_posts_custom_column', 'populate_column_data', 10, 2);
add_action('manage_pages_custom_column', 'populate_column_data', 10, 2);

function column_sortable_func($columns)
{
    $columns['wordcount'] = 'wordcount';
    return $columns;
}

add_filter('manage_edit-post_sortable_columns', 'column_sortable_func');

// Custom sorting logic for the "wordcount" column
function custom_wordcount_orderby($query)
{
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ('wordcount' == $orderby) {
        $query->set('meta_query', array(
            'relation' => 'OR',
            array(
                'key' => 'word_count',
                'compare' => 'EXISTS',
            ),
            array(
                'key' => 'word_count',
                'compare' => 'NOT EXISTS',
            ),
        ));
    }
}

add_action('pre_get_posts', 'custom_wordcount_orderby');

function add_checkout_custom_message() {
    echo '<div class="custom-checkout-message" style="padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd; margin-bottom: 20px;">
            <p><strong>আপনার অর্ডার সাবমিট করার আগে তথ্যগুলো ঠিকমত চেক করে নিন।</strong></p>
          </div>';
}
add_action( 'woocommerce_before_checkout_form', 'add_checkout_custom_message' );
