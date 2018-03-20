<?php
use App\Models\Topic;

return [
    'title' => '话题',
    'single' => '话题',
    'model' => Topic::class,

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title' => '话题',
            'sortable' => false,
            'output' => function($value, $model) {
                return '<div style="max-width:260px">' . model_link($value, $model) . '</div>';
            },
        ],
        'user' => [
            'title' => '作者',
            'sortable' => false,
            'output' => function($value, $model) {
                $avatar = $model->user->avatar;
                $value = empty($avatar) ? 'N/A' : '<img src="' . $avatar . '" style="width:22px;height:22px;"> ' . $model->user->name;
                return model_link($value, $model);
            },
        ],
        'category' => [
            'title' => '分类',
            'sortable' => false,
            'output' => function($value, $model) {
                return model_admin_link($model->category->name, $model->category);
            },
        ],
        'reply_count' => [
            'title' => '评论',
        ],
        'operation' => [
            'title' => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => '标题',
        'user' => [
            'title' => '用户',
            'type' => 'relationship',
            'name_field' => 'name',

            //自动补全
            'autocomplete' => true,

            //自动补全搜索字段
            'search_fields' => ["CONCAT(id, ' ', name)"],

            //自动补全排序
            'options_sort_field' => 'id',
        ],
        'category' => [
            'title' => '分类',
            'type' => 'relationship',
            'name_field' => 'name',
            'search_fields' => ["CONCAT(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'reply_count' => [
            'title' => '评论',
        ],
        'view_count' => [
            'title' => '查看',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'user' => [
            'title' => '用户',
            'type' => 'relationship',
            'name_field' => 'name',
            'autocomplete' => true,
            'search_fields' => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'category' => [
            'title' => '分类',
            'type' => 'relationship',
            'name_field' => 'name',
            'search_fields' => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
    ],
    'rules' => [
        'title' => 'required',
    ],
    'message' => [
        'title.required' => '请填写标题',
    ],
];
