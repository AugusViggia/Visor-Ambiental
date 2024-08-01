<?php

if (!function_exists('map_date')) {
    /**
     * @param string|null $date
     * @param string $fromFormat
     * @return \Carbon\Carbon|null
     */
    function map_date(string $date = null, $fromFormat = 'd/m/Y'): ?\Carbon\Carbon
    {
        return (!empty($date))
            ? \Carbon\Carbon::createFromFormat($fromFormat, $date)
            : null;
    }
}

if (!function_exists('flashMessage')) {
    /**
     * @param string $message
     * @param string $type
     * @param array $options
     */
    function flashMessage($message)
    {
        session()->flash('flashMessage', $message);
    }
}

if (!function_exists('translations')) {
    /**
     * @param $json
     * @return array|mixed
     */
    function translations($json)
    {
        if (!file_exists($json)) {
            return [];
        }
        return json_decode(file_get_contents($json), true);
    }
}

if (!function_exists('loadTranslations')) {
    /**
     * @param $json
     * @return array|mixed
     */
    function loadTranslations()
    {
        return translations(
            lang_path(app()->getLocale() . '.json')
        );
    }
}

if (!function_exists('flashAlert')) {
    /**
     * @param $json
     * @return array|mixed
     */
    function flashAlert(
        $message,
        \App\Services\Helpers\Alert\AlertType $type = \App\Services\Helpers\Alert\AlertType::SUCCESS
    ) {
        return (new App\Services\Helpers\Alert\Alert())->set($message, $type);
    }
}

if (!function_exists('getAlert')) {
    /**
     * @param $json
     * @return array|mixed
     */
    function getAlert()
    {
        return (new App\Services\Helpers\Alert\Alert())->get();
    }
}

if (!function_exists('minutesToHours')) {
    /**
     * @param $minutes float
     * @return float
     */
    function minutesToHours(float $minutes): float
    {
        return number_format($minutes / 60, 2);
    }
}
