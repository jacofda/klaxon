<?php

namespace Jacofda\Klaxon\Models\Erp;

use Jacofda\Klaxon\Models\{Product, Primitive};

class Check extends Primitive
{
    public $timestamps = false;

    public function checkable()
    {
        return $this->morphTo();
    }

    public static function SaveOneCheck($name, $model)
    {
        return self::create([
            'name' => $name,
            'checkable_id' => $model->id,
            'checkable_type' => get_class($model)
        ]);
    }

    public static function SaveChecks($arr, $model)
    {
        foreach($arr as $value)
        {
            if(!is_null($value))
            {
                self::SaveOneCheck($value, $model);
            }
        }
        return $model->checks;
    }

    public static function UpdateChecks($names, $model, $ids = null)
    {

        if($model->checks()->exists())
        {

            if(is_null($names))
            {
                foreach($model->checks as $check)
                {
                    $check->delete();
                }
                return $model->checks;
            }

            foreach($names as $key => $name)
            {
                if(!is_null($ids))
                {
                    if(isset($ids[$key]))
                    {
                        $check = self::where('id', $ids[$key])->first();
                        if($check)
                        {
                            $check->update(['name' => $name]);
                        }
                        else
                        {
                            if(!is_null($name))
                            {
                                self::SaveOneCheck($name, $model);
                            }
                        }
                    }
                    else
                    {
                        if(!is_null($name))
                        {
                            self::SaveOneCheck($name, $model);
                        }
                    }
                }
            }
        }
        else
        {
            self::SaveChecks($names, $model);
        }

        return $model->checks;
    }



}
