<?php

namespace TinyPixel\Settings;

// Illuminate framework
use \Illuminate\Support\Collection;
use \Illuminate\Support\Facades\Cache;

// Roots
use \Roots\Acorn\Application;

// Internal
use \TinyPixel\Settings\Traits;

/**
 * Dashboard
 *
 * @author  Kelly Mears <kelly@tinypixel.dev>
 * @license MIT
 * @since   1.0.0
 */
class Dashboard
{
    use Traits\DashboardMetaBoxes;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function init(Collection $config)
    {
        $this->settings = $config;

        $this->columnsCount = $this->settings->get('columns_count');

        $this->metaBoxSettings = Collection::make($this->settings->get('meta_boxes'));

        add_action('wp_dashboard_setup', [$this, 'disableDashboardWidgets'], 999);
        add_action('admin_head-index.php', [$this, 'setDashboardColumns']);
    }

    /**
     * Disables all dashboard widgets
     *
     * @return void
     */
    public function disableAllDashboardWidgets()
    {
        global $wp_meta_boxes;

        foreach ($wp_meta_boxes['dashboard']['normal']['core'] as $widget) {
            unset($widget);
        }

        foreach ($wp_meta_boxes['dashboard']['side']['core'] as $widget) {
            unset($widget);
        }
    }

    /**
     * Disables dashboard widgets
     *
     * @return void
     */
    public function disableDashboardWidgets()
    {
        Cache::rememberForever('dashboard-widgets', function () {
            $this->metaBoxSettings->each(function ($status, $metabox) {
                if ($status == false) {
                    global $wp_meta_boxes;

                    $location = $this->metaBoxes[$metabox]['location'];
                    $name = $this->metaBoxes[$metabox]['name'];

                    if (isset($wp_meta_boxes['dashboard'][$location]['core'][$name])) {
                        unset($wp_meta_boxes['dashboard'][$location]['core'][$name]);
                    }
                }
            });
        });
    }

    /**
     * Sets dashboard columns count
     *
     * Owes a debt of gratitude to:
     * @author Darren Jacoby
     * @link   https://github.com/soberwp/intervention/blob/master/src/Module/UpdateDashboardColumns.php
     */
    public function setDashboardColumns()
    {
        Cache::rememberForever('dashboard-columns', function () {
            if (isset($this->columnsCount) && $this->columnsCount !== 0) {
                $width = 100 / $this->columnsCount;
            }

            if (isset($width)) {
                // Column CSS
                echo "<style>.postbox-container { min-width: {$width} !important; }</style>";
                echo "<style>#wpbody-content #dashboard-widgets #postbox-container-1 {width: {$width} !important;}</style>";
                echo "<style>@media only screen and (max-width: 1499px) and (min-width: 800px) {#wpbody-content #dashboard-widgets .postbox-container {width: {$width}%}</style>";
                echo "<style>@media only screen and (max-width: 1499px) and (min-width: 800px) {#wpbody-content #dashboard-widgets #postbox-container-2, #wpbody-content #dashboard-widgets #postbox-container-3, #wpbody-content #dashboard-widgets #postbox-container-4 {width: {$width}% !important}}</style>";
                echo "<style>@media only screen and (max-width: 1800px) and (min-width: 1500px) {#wpbody-content #dashboard-widgets .postbox-container {width: {$width}%;}</style>";

                // Sortable areas
                echo "<style>.meta-box-sortables.ui-sortable.empty-container::after {display: none !important;}</style>";

                /**
                 * For single column layout
                 */
                if ($width === 100) {
                    echo "<style>.meta-box-sortables.ui-sortable.empty-container {display: none !important;}</style>";

                /**
                 * For two column layout
                 */
                } elseif ($width === 50) {
                    echo "<style>#postbox-container-3 .meta-box-sortables.ui-sortable.empty-container {display: none !important;}</style>";
                    echo "<style>#postbox-container-4 .meta-box-sortables.ui-sortable.empty-container {display: none !important;}</style>";

                /**
                 * For three+ column layout
                 */
                } else {
                    echo "<style>#postbox-container-2 .meta-box-sortables.ui-sortable.empty-container {display: block !important;}</style>";
                    echo "<style>#postbox-container-3 .meta-box-sortables.ui-sortable.empty-container {display: block !important;}</style>";
                    echo "<style>@media only screen and (max-width: 1499px) and (min-width: 800px) {#postbox-container-3 .meta-box-sortables.ui-sortable.empty-container {display: block !important; min-height: 100px !important; height: 250px !important; border: 3px dashed #b4b9be !important;}}</style>";
                    echo "<style>#postbox-container-4 .meta-box-sortables.ui-sortable.empty-container {display: none !important;}</style>";
                }
            }
        });
    }
}