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

/**
 * 记录日志
 * @param $text
 * @param string $path
 * @param string $ext
 */
function write_text_to_log($text, $path = '/Log/', $ext = 'txt')
{
    $path = public_path() . $path;
    $save_path = str_replace('\\', '/', $path);

    $ym = date('Y_m');
    $save_path .= $ym . '/';
    if (!file_exists($save_path)) {
        mkdir($save_path);
    }

    $d = date('d');
    $save_path .= $d . '/';
    if (!file_exists($save_path)) {
        mkdir($save_path);
    }

    $date = date('YmdH');
    $file_name = $date . $ext;
    $file_path = $save_path . $file_name;
    $msg = date('H:i:s') . '  ' . $text . PHP_EOL;
    file_put_contents($file_path, $msg, FILE_APPEND);
}