<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Link extends Model
{
    //
    protected $fillable = ['title', 'link'];

    public $cache_key = 'larabbs_key';
    protected $cache_expire_in_minutes = 1440;

    public function getAllCached()
    {
        //尝试从缓存中取出cache_key对应数据，如果能取到，直接返回数据
        //否则运行匿名函数中的代码来去除活跃用户的数据，同时缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function () {
            return $this->all();
        });
    }
}
