<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index() {

        $memos = Memo::all();
        return response()->json($memos);
    }

    public function store(Request $request) {
        $memo = Memo::create([
            'content' => $request->content,
        ]);
        return response()->json($memo, 201);
//        201は成功を意味するHTTPステータスコード
    }
}
