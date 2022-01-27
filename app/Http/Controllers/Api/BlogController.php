<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $blog = new Blog();
        $blog->user_id = $user_id;
        $blog->title = $request->title;
        $blog->content = $request->content;

        $blog->save();

        return response()->json([
            'status' => 1,
            'msg' => 'Blog creado exitosamente'
        ]);
    }

    public function list() {
        $user_id = auth()->user()->id;

        $blogs = Blog::where('user_id', $user_id)->get();

        return response()->json([
            'status' => 1,
            'msg' => 'Listado de blogs',
            'data' => $blogs
        ]);
    }

    public function show($id) {

    }

    public function update(Request $request, $id) {
        $user_id = auth()->user()->id;

        if (Blog::where(['user_id' => $user_id, 'id' => $id])->exists()) {
            $blog = Blog::find($id);

            $blog->title = isset($request->title) ? $request->title : $blog->title;
            $blog->content = isset($request->content) ? $request->content : $blog->content;

            $blog->save();

            return response()->json([
                'status' => 1,
                'msg' => 'Blog actualizado correctamente',
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'No se encontró el blog',
            ], 404);
        }

    }

    public function delete($id) {
        $user_id = auth()->user()->id;

        if (Blog::where(['id' => $id, 'user_id' => $user_id])->exists()) {
            $blog = Blog::where(['id' => $id, 'user_id' => $user_id])->first();
            $blog->delete();

            return response()->json([
                'status' => 1,
                'msg' => 'Blog eliminado correctamente',
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'No se encontró el blog',
            ], 404);
        }

    }
}
