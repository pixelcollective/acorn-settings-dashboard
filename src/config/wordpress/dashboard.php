<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dashboard Columns
    |--------------------------------------------------------------------------
    |
    | Set the number of columns to be displayed on the dashboard
    |
    */

    'columns_count' => 1,


    /*
    |--------------------------------------------------------------------------
    | Dashboard Metaboxes
    |--------------------------------------------------------------------------
    |
    | Filter the metaboxes enabled on the dashboard
    |
    */

    'meta_boxes' => [
        'activity'        => false,
        'at_a_glance'     => true,
        'recent_comments' => true,
        'incoming_links'  => true,
        'plugins'         => true,
        'primary'         => true,
        'secondary'       => true,
        'quick_press'     => true,
        'recent_drafts'   => true,
    ],

];
