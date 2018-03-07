<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function show(Category $category,Request $request,Topic $topic)
    {
        //读取分类ID 关联的话题，分页
        $topics = $topic->withOrder($request->order)
                        ->where('category_id', $category->id)
                        ->paginate(20);

        //传参变量,话题和分类模板中
        return view('topics.index', compact('topics', 'category'));
    }
}
