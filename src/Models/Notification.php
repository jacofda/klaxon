<?php

namespace Jacofda\Klaxon\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = array();

    public function notificationable()
    {
        return $this->morphTo();
    }

    public function getDirectoryAttribute()
    {
        return str_plural(strtolower($this->class));
    }

    //get url of element
    public function getUrlAttribute()
    {
        if(strpos($this->notificationable_type, 'Fe') !== false)
        {
            return null;
        }
        else
        {
            //return $this->notificationable;
            return config('app.url') . $this->notificationable->directory . '/' . $this->notificationable->id;
        }
    }

    public function getModalAttribute()
    {
        if(is_null($this->url))
        {
            $arr = explode("\\", $this->notificationable_type);
            return (object) ['class' => end($arr)];
        }
        return null;
    }

    public function scopeUnread($query)
    {
        $query = $query->where('read', 0);
    }

    public static function countUnread()
    {
        return self::unread()->count();
    }
}
