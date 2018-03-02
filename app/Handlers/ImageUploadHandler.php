<?php
/**
 * 用于：
 * author： Xiaoxiaowei
 * Date：  2018-03-02 14:10
 */
namespace App\Handlers;

use Image;

class ImageUploadHandler{

    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        //存储文件夹规则
        $folder_name = "uploads/images/$folder/" . date("Ym", time()) . '/' . date("d", time()) . '/';

        //存储物理路径
        $upload_path = public_path() . '/' . $folder_name;

        //获取后缀
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' .$extension;

        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);

        //进行裁切
        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name$filename"
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        //实例化
        $image = Image::make($file_path);

        //调整大小
        $image->resize($max_width, null, function ($constraint) {
            //设定宽度是 $max_width, 高度等比例缩放
            $constraint->aspectRatio();

            //防止图片尺寸变大
            $constraint->upsize();
        });

        //对修改后的图片保存
        $image->save();
    }
}