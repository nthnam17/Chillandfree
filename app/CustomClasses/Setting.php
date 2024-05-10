<?php

namespace App\CustomClasses;

use App\Models\General;
use Cache;

class Setting {

    /**
     * The array of settings
     *
     * @var array $settings
     */
    protected $settings = [];

    /**
     * Instantiate the class.
     */
    public function __construct()
    {
        $this->loadSettings();
    }

    /**
     * Pull the settings from the database and cache them.
     *
     * @return void;
     */
    protected function loadSettings()
    {
        $minutes = 1440; #1day
        Cache::rememberForever('settings', function() {
            return General::first();
        });
        $this->settings = Cache::get('settings');
    }

    /**
     * Get all settings.
     *
     * @return array;
     */
    public function all()
    {
        return $this->settings;
    }

    /**
     * Get a setting value by it's key.
     * An array of keys can be given to retrieve multiple key-value pair's.
     *
     * @param  string|array  $key;
     * @return string|array;
     */
    public function get($key)
    {
        if( is_array($key) ) {
            $keys = [];

            foreach($key as $k) {
                $keys[$k] = $this->settings[$k];
            }

            return $keys;
        }

        return $this->settings[$key];
    }

}
