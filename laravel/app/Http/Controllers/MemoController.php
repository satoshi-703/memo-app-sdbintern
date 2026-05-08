<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index(Request $request) {
        $query = Memo::query();

        $query->where('deleted', 0);

        if($request->has('q') && !empty($request->q)) {
            $keyword = $request->query('q');
            $query->where('content', 'LIKE', "%{$keyword}%");
        }
        $memos = $query->latest()->get();
        return response()->json($memos);

    }

    public function store(Request $request) {
        $memo = Memo::create([
            'content' => $request->content,
        ]);
        return response()->json($memo, 201);
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

    public function restore($id) {
        $memo = Memo::findorFail($id);

        $memo->deleted = 0;
        $memo->save();

        return response()->json(['message' => '復元完了']);
    }
}

