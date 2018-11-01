<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Settings list
     * [KEY, FIELD TYPE, TRANSLATE KEY]
     * @var array
     */
    public static $settings = [
        ['text', 'site_name', 'Título del sitio'],
        ['text', 'site_description', 'Descripción del sitio'],
        ['text', 'site_locale', 'Localidad (ejemplo: es_MX)'],
        ['---'],
        ['boolean', 'users_can_register', '¿Se pueden registrar los usuarios?'],
        ['text', 'users_admin', 'Correos de usuarios administradores, separados por ","'],
        ['---'],
        ['text', 'facebook_page', 'URL de la página de facebook'],
        ['text', 'facebook_appid', 'ID de la app en facebook'],
        ['text', 'addthis_code', 'Código del widget AddThis'],
        ['---'],
        ['text', 'google_analytics', 'Código de Google Analytics (ejemplo: UA-XXXXX-X)'],
        ['text', 'google_site_verification', 'Código de verificacion para Google Webmasters'],
        ['---'],
        ['text', 'google_adsense', 'Código de Google Adsense (adaptable)'],
    ];

    /**
     * Get a setting
     * @param $key
     * @return string
     */
    public static function get($key, $default = '')
    {
        $item = Settings::where('key', $key)->first();
        return $item ? $item->value : $default;
    }

    /**
     * Store a setting
     * @param $key
     * @param $value
     */
    public static function put($key, $value)
    {
        $item = Settings::where('key', $key)->first();
        if ($item) {
            $item->value = $value;
            $item->save();
        } else {
            $item = new Settings(['key' => $key, 'value' => $value]);
            $item->save();
        }
    }
}
