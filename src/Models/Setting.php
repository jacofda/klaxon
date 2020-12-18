<?php

namespace Jacofda\Klaxon\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Jacofda\Klaxon\Models\Company;

class Setting extends Model
{
    protected $guarded = array();

    public $timestamps = false;

    protected $casts = [
        'fields' => 'array'
    ];

    public function getUrlAttribute()
    {
        return config('app.url').'settings/'.$this->id;
    }

    public function getCountFieldsAttribute()
    {
        if($this->fields)
        {
            return count($this->fields);
        }
        return 0;
    }

    public static function defaultTestEmail($emails = null)
    {
        if(is_null($emails))
        {
            $settings = self::where('model', 'Newsletter')->first()->fields;
            if($settings)
            {
                if(isset($settings['default_test_email']))
                {
                    return explode(';', $settings['default_test_email']);
                }
            }
            return null;
        }
        return explode(';', $emails);
    }

    public static function defaultSendFrom()
    {
        $settings = self::where('model', 'Newsletter')->first()->fields;
        if($settings)
        {
            if(isset($settings['invia_da_email']))
            {
                if(isset($settings['invia_da_nome']))
                {
                    return [
                        'name' => $settings['invia_da_nome'],
                        'address' => $settings['invia_da_email'],
                    ];
                }

                return [
                    'name' => config('app.name'),
                    'address' => $settings['invia_da_email'],
                ];
            }
        }
        return [
            'name' => config('app.name'),
            'address' => auth()-user()->email,
        ];
    }

    public static function fe()
    {
        $fe = Cache::remember('fe', 60*10, function () {
            return (object) self::where('model', 'Fe')->first()['fields'];
        });
        return $fe;
    }

    public static function base()
    {
        $base = Cache::remember('base', 60*24*7, function () {
            return (object) self::where('model', 'Base')->first()['fields'];
        });
        return $base;
    }

    public static function HomeId()
    {
        $homeId = Cache::remember('homeId', 60*24*7, function () {
            return Company::where('rag_soc', self::base()->rag_soc)->first()->id;
        });
        return $homeId;
    }

    public static function socials()
    {
        $social = Cache::remember('social', 60*24*7, function () {
            return (object) self::where('model', 'Social')->first()['fields'];
        });
        return $social;
    }


/**
 * return one or all istances of SMTP configuration
 * @param  [int] $id [id smtp]
 * @return [arr]     [single or multiple instance of smtp configurations]
 */
    public static function Personale()
    {
        return self::where('model', 'Personale')->first()['fields'];
    }


/**
 * return one or all istances of SMTP configuration
 * @param  [int] $id [id smtp]
 * @return [arr]     [single or multiple instance of smtp configurations]
 */
    public static function smtp($id = null)
    {
        if(is_null($id))
        {
            return (object) self::where('model', 'SMTP')->first()['fields'];
        }

        $count = 0;
        foreach(self::where('model', 'SMTP')->first()['fields'] as $smtp)
        {
            if($count == $id)
            {
                return $smtp;
            }
            $count++;
        }
    }

    public static function smtpPluck()
    {
        $arr = [];
        foreach(self::where('model', 'SMTP')->first()['fields'] as $smtp)
        {
            if($smtp['MAIL_FROM_NAME'] != '')
            {
                $arr[] = $smtp['MAIL_FROM_NAME'] .' - ' .  $smtp['MAIL_FROM_ADDRESS'];
            }
        }

        if(count($arr) == 0)
        {
            return [0 => 'Default'];
        }

        return $arr;
    }


    public function areFieldsFilled()
    {
        foreach($this->fields as $key => $value)
        {
            if($value != '')
            {
                return true;
            }
        }
        return false;
    }

    public function getAddress()
    {
        if($this->areFieldsFilled())
        {
            $html = $this->fields['rag_soc'].'<br>';
            $html .= $this->fields['indirizzo'].'<br>';
            $html .= $this->fields['cap'].', '.$this->fields['citta'].' '.$this->fields['provincia'].' '.$this->fields['nazione'].'<br>';
            return $html;
        }
        return 'My Company, <br> Via indirizzo 7, 12345 Città (AA) IT';
    }

    public static function DefaultLogo()
    {
        $logo = Cache::remember('logo', 60*24*7, function () {
            if(self::base()->logo_img != "")
            {
                return asset('storage/settings/'.self::base()->logo_img);
            }
            return asset('img/AdminLTELogo.png');
        });
        return $logo;
    }

    public static function FatturaLogo()
    {
        $fattura_logo = Cache::remember('fattura_logo', 60*24*7, function () {
            if(self::base()->logo_fattura_img != "")
            {
                return public_path('storage/settings/'.self::base()->logo_fattura_img);
            }
            return '';
        });
        return $fattura_logo;
    }

    public static function FatturaFooterImg()
    {
        $fattura_footer_img = Cache::remember('fattura_footer_img', 60*24*7, function () {
            if(self::base()->footer_img != "")
            {
                return public_path('storage/settings/'.self::base()->footer_img);
            }
            return '';
        });
        return $fattura_footer_img;
    }



}
