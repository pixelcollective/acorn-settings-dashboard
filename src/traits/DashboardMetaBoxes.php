<?php

namespace TinyPixel\Settings\Traits;

trait DashboardMetaBoxes
{
    /**
     * Meta boxes
     *
     * @var array
     */
    public $metaBoxes = [
        'activity'        => [
            'location' => 'normal',
            'name'     => 'dashboard_activity'
        ],
        'right_now'       => [
            'location' => 'normal',
            'name'     => 'dashboard_right_now'
        ],
        'recent_comments' => [
            'location' => 'normal',
            'name'     => 'dashboard_recent_comments'
        ],
        'incoming_links' => [
            'location' => 'normal',
            'name'     => 'dashboard_incoming_links'
        ],
        'plugins' => [
            'location' => 'normal',
            'name'     => 'dashboard_plugins'
        ],
        'primary' => [
            'location' => 'normal',
            'name'     => 'dashboard_primary'
        ],
        'secondary' => [
            'location' => 'normal',
            'name'     => 'dashboard_secondary'
        ],
        'quick_press' => [
            'location' => 'normal',
            'name'     => 'dashboard_quick_press'
        ],
        'recent_drafts' => [
            'location' => 'normal',
            'name'     => 'dashboard_recent_drafts'
        ],
        'primary'  => [
            'location' => 'side',
            'name'     => 'dashboard_primary'
        ],
        'secondary' => [
            'location' => 'side',
            'name'     => 'dashboard_secondary'
        ],
        'quick_press' => [
            'location' => 'side',
            'name'     => 'dashboard_quick_press'
        ],
        'recent_drafts' => [
            'location' => 'side',
            'name'     => 'dashboard_recent_drafts'
        ],
    ];
}