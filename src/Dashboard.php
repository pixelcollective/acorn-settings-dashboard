<?php

namespace TinyPixel\Settings;

// Illuminate framework
use \Illuminate\Support\Collection;

// Roots
use \Roots\Acorn\Application;

// Internal
use \TinyPixel\Settings\Traits;

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

        $this->metaBoxSettings = Collection::make(
            $this->settings->get('meta_boxes')
        );

        add_action('wp_dashboard_setup', [$this, 'disableDashboardWidgets'], 999);
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

    public function disableDashboardWidgets()
    {
        global $wp_meta_boxes;

        $this->metaBoxSettings->each(function ($status, $metabox) use ($wp_meta_boxes) {
            if ($status == false) {
                $location = $this->metaBoxes[$metabox]['location'];
                $name = $this->metaBoxes[$metabox]['name'];
                if (isset($wp_meta_boxes['dashboard'][$location]['core'][$name])) {
                    unset($wp_meta_boxes['dashboard'][$location]['core'][$name]);
                }
            }
        });
    }
}