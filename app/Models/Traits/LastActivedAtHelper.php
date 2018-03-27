<?php
namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{
    //缓存相关
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {
        //获取今天的日期
        $date = Carbon::now()->toDateString();

        //redis 哈希表的命名
        $hash = $this->hash_prefix . $date;

        //字段名称
        $field = $this->field_prefix . $this->id;

        //dd(Redis::hGetAll($hash));

        //当前时间
        $now = Carbon::now()->toDateTimeString();

        Redis::hSet($hash, $field, $now);
    }
}