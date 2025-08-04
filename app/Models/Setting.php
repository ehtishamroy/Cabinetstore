<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description'
    ];

    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Get a setting value by key
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        switch ($setting->type) {
            case 'number':
                return (float) $setting->value;
            case 'boolean':
                return (bool) $setting->value;
            case 'json':
                return json_decode($setting->value, true);
            default:
                return $setting->value;
        }
    }

    /**
     * Set a setting value by key
     */
    public static function setValue($key, $value, $type = 'string', $group = 'general', $label = null, $description = null)
    {
        $setting = self::where('key', $key)->first();
        
        if ($setting) {
            $setting->update([
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'label' => $label,
                'description' => $description
            ]);
        } else {
            self::create([
                'key' => $key,
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'label' => $label,
                'description' => $description
            ]);
        }
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup($group)
    {
        return self::where('group', $group)->get();
    }
}
