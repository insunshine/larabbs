<?php
/**
 * 用于：
 * author： Xiaoxiaowei
 * Date：  2018-02-27 16:15
 */
function route_class(){
    return str_replace('.', '-', Route::currentRouteName());
}