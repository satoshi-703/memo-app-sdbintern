<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index() {

        $memos = Memo::latest()->get();
        return response()->json($memos);

//        $mockData = [
//            [
//                'id' => 1,
//                'content' => 'これはmockデータだよーん',
//                'created_at' => '2020-01-01 10:00:00',
//                'deleted' => false
//            ],
//            [
//                'id' => 2,
//                'content' => 'メモアプリ作成頑張るのだ！！',
//                'created_at' => '2022-01-01 10:00:00',
//                'deleted' => false
//            ]
//        ];
//
//        return response()->json($mockData);

    }

    public function store(Request $request) {
        $memo = Memo::create([
            'content' => $request->content,
        ]);
        return response()->json($memo, 201);
//        201は成功を意味するHTTPステータスコード
    }

    public function updata(Request $request, $id) {
        $memo = Memo::findOrFail($id);

        if ($request->has('content')) {
            $memo->content = $request->input('content');
        }

        $memo->save();

        return response()->json(['message' => '更新完了']);

    }

    public function destroy($id) {
        $memo = Memo::findOrFail($id);

        $memo->deleted = 1;
        $memo->save();

        return response()->json(['message' => '更新完了']);
    }
}

