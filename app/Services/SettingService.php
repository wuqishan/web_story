<?php

namespace App\Services;

use App\Helper\CacheHelper;
use App\Models\Setting;

class SettingService extends Service
{
    public function save($param, $id = 0)
    {
        $data = [];
        $id = intval($id);
        if ($id === 0) {
            $data = ['name' => '', 'value' => ''];
        }

        if (isset($param['name'])) {
            $data['name'] = strip_tags($param['name']);
        }

        if (isset($param['value'])) {
            $data['value'] = strip_tags($param['value']);
        }

        if (isset($param['orderby'])) {
            $data['orderby'] = intval($param['orderby']);
        }

        if ($id > 0) {
            $results = Setting::where('id', $id)->update($data);
        } else {
            $results = Setting::insertGetId($data);
        }

        return $results;
    }

    public function getByName($name)
    {
        $model = new Setting();
        if (is_array($name)) {
            $model = $model->whereIn('name', $name);
        } else {
            $model = $model->where('name', $name);
        }
        $model = $model->orderBy('orderby', 'asc')->get();
        $setting = empty($model) ? [] : $model->toArray();

        return $setting;
    }

    public function getByNameFromCache($name)
    {
        $cache_key = is_array($name) ? implode('-', $name) : $name;
        $setting = CacheHelper::get($cache_key);
        if (empty($setting)) {
            $setting = $this->getByName($name);
            if (! empty($setting)) {
                CacheHelper::set($cache_key, $setting);
            }
        }

        return (array) $setting;
    }

    public function resetCache()
    {
//        $a = system('php /home/wells/www/story/artisan view:clear', $out);
//        $a = passthru('php /home/wells/www/story/artisan view:clear', $out);
//        $a = exec('php /home/wells/www/story/artisan view:clear', $out, $return);
//        $a = proc_open('php /home/wells/www/story/artisan view:clear');
//
//        dd($a);
        return true;
    }

    public function delete($id, $del_image = false)
    {
        $id = intval($id);
        if ($del_image) {
            $setting = Setting::find($id)->toArray();
            @unlink(public_path($setting['value']));
        }
        $results = Setting::destroy($id);

        return $results;
    }
}