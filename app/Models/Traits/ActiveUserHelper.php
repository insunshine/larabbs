<?php
/**
 * 用于：计算活跃用户
 * author： Xiaoxiaowei
 * Date：  2018-03-21 10:12
 */

namespace App\Models\Traits;

use App\Models\Topic;
use App\Models\Reply;
use App\Models\User;
use Carbon\Carbon;
use Cache;
use DB;
use function GuzzleHttp\Psr7\uri_for;

trait ActiveUserHelper
{
    //存放临时用户数据
    protected $users = [];

    //配置信息
    protected $topic_weight = 4;    //话题权重
    protected $_reply_weight = 1;   //回复权重
    protected $pass_days = 7;       //活跃期
    protected $user_number = 6;    //取出来多少用户

    //缓存相关配置
    protected $cache_key = 'larabbs_active_users';
    protected $cache_expire_in_minutes = 65;

    public function getActiveUsers()
    {
        //尝试从缓存中取出 cache_key 对应的数据，如果存在，直接返回数据
        //否则运行匿名函数中的代码来取出活跃用户的数据，同时缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function (){
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        //取得活跃用户列表
        $active_users = $this->calculateActiveUsers();
        //缓存
        $this->cacheActiveUsers($active_users);

    }

    private function calculateActiveUsers()
    {
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        //数组按照得分排序
        $users = array_sort($this->users, function ($user) {
            return $user['score'];
        });

        //倒序
        $users = array_reverse($users, true);

        //只获取需要的数量
        $users = array_slice($users, 0, $this->user_number, true);

        //新建一个空集合
        $active_user = collect();

        foreach ($users as $user_id=>$user) {
            //搜寻是否可以找到用户
            $user = User::find($user_id);

            //如果数据库有该用户
            if ($user) {
                $active_user->push($user);
            }
        }
        return $active_user;
    }

    private function calculateTopicScore()
    {
        //从话题数据表中取出限定时间范围 $pass_days 内有发表过话题的用户
        //同时取出用户此段时间内发布的话题数量
        $topic_users = Topic::query()
            ->select(DB::raw('user_id, count(*) as topic_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();

        //根据话题数量计算得分
        foreach ($topic_users as $value) {
            $this->users[$value->user_id]['score'] = $value->topic_count * $this->topic_weight;
        }

    }

    private function calculateReplyScore()
    {
        //从回复数据表取出限定时间范围 $pass_days 内有发表过回复的用户
        //同时取出用户此段时间发布回复的数量
        $reply_users = Reply::query()
            ->select(DB::raw('user_id,count(*) as reply_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();

        //根据回复数量计算得分
        foreach ($reply_users as $value) {
            $reply_score = $value->reply_count * $this->_reply_weight;
            if (isset($this->users[$value->user_id])) {
                $this->users[$value->user_id]['score'] += $reply_score;
            } else {
                $this->users[$value->user_id]['score'] = $reply_score;
            }
        }
    }

    private function cacheActiveUsers($active_users)
    {
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_minutes);
    }
}
