<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{
    //缓存相关
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {
        //获取今天的redis 哈希表的命名
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        //字段名称
        $field = $this->getHashField();

        //dd(Redis::hGetAll($hash));

        //当前时间
        $now = Carbon::now()->toDateTimeString();

        Redis::hSet($hash, $field, $now);
    }

    public function syncUserActivedAt()
    {
        //获取昨天的redis哈希表的命名
        $hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());

        //从redis中获取所有哈希表的数据
        $dates = Redis::hGetAll($hash);

        //遍历，同步到数据库
        foreach ($dates as $user_id => $actived_at) {
            //将user_1转为1
            $user_id = str_replace($this->field_prefix, '', $user_id);

            //只有当用户存在时才更新到数据库
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        Redis::del($hash);
    }

    public function getLastActivedAtAttribute($value)
    {
        //获取今日对应的哈希表名称
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        //字段名称
        $field = $this->getHashField();

        $datetime = Redis::hGet($hash, $field) ? : $value;

        if ($datetime) {
            //如果存在，返回对应的Carbon实体
            return new Carbon($datetime);
        } else {
            //否则使用用户注册时间
            return $this->created_at;
        }
    }

    public function getHashFromDateString($date)
    {
        //哈希表的命名
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        return $this->field_prefix . $this->id;
    }
}