<?php

function manage_column_learn($column)
{
    print_r($column);
    $column['id'] = __('Post Id', 'learn');
    $column['thumbnail'] = __('Thumbnail', 'learn');
    return $column;
}

add_filter('manage_posts_columns', 'manage_column_learn');
add_filter('manage_pages_columns', 'manage_column_learn');
function populate_column_data($column, $post_id)
{
    if ('id' == $column) {
        echo $post_id;
    } elseif ('thumbnail' == $column) {
        $thumbnail = get_the_post_thumbnail($post_id, array(80.80));
        echo $thumbnail;
    }
}

add_action('manage_posts_custom_column', 'populate_column_data', 10, 2);
add_action('manage_pages_custom_column', 'populate_column_data', 10, 2);