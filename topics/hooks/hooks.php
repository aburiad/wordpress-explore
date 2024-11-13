<?php

do_action('prefix_display_custom_msg');

function prefix_display_custom_my_mssage()
{
    echo "Hello This is custom override message";
}

add_action('prefix_display_custom_msg', 'prefix_display_custom_my_mssage');

