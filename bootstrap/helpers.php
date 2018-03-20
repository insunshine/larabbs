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

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    //获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);

    //初始化前缀
    $prefix = $prefix ? "/$prefix/" : "/";

    //使用站点URL拼接全量URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    //拼接HTML A 标签，并返回
    return '<a href="' . $url . '"target=_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    //从实体中获取完整类名，比兔 App\Models\User
    $full_class_name = get_class($model);

    //获取基础类名，例如传参`App\Models\User`会得到`User`
    $class_name = class_basename($full_class_name);

    //蛇形命名，例如：传参`User`会得到`user`,`FooBar`得到`foo_bar`
    $snake_case_name = snake_case($class_name);

    //获取子串的复数形式
    return str_plural($snake_case_name);
}