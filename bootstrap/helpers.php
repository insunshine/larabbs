<?php
/**
 * 用于：
 * author： Xiaoxiaowei
 * Date：  2018-02-27 16:15
 */

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 生成简介
 * @param $value
 * @param int $length
 * @return string
 */
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}