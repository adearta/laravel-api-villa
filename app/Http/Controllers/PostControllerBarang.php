<?php

namespace App\Http\Controllers;

use App\Models\ImageBarang;
use Illuminate\Http\Request;
use App\Models\Post;
use Dotenv\Store\FileStore;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostControllerBarang extends Controller
{
    //
    public function index()
    {

        $posts = Post::latest()->get();
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data'    => $posts
        ], 200);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $post = Post::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $post
        ], 200);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpg,jpeg,png|max:5000',
            'nama_barang'   => 'required',
            'harga_barang' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($file = $request->file('image')) {


            $path = $file->store('Gambar/ListVilla', 'public');
            $name = $file->getClientOriginalName();
            $save = new Post();
            $save->name = $name;
            $save->path = $path;
            $save->nama_barang = $request->nama_barang;
            $save->harga_barang = $request->harga_barang;
            $save->ukuran = $request->ukuran;
            $save->jenis_barang = $request->jenis_barang;
            $save->save();

            return response()->json([
                'success' => true,
                'message' => 'success upload images',
                'file' => $file
            ]);
        }

        //save to database


        //success save to database
        // if ($post) {

        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Post Created',
        //         'data'    => $post
        //     ], 201);
        // }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post Failed to Save',
        ], 409);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Post $post, $id)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_barang'     => 'required',
            'harga_barang'   => 'required',
            'ukuran'    => 'required',
            'jenis_barang'  => 'required'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $post = Post::findOrFail($id);

        if ($post) {

            //update post
            $post->update([
                'nama_barang'     => $request->nama_barang,
                'harga_barang'   => $request->harga_barang,
                'ukuran'    => $request->ukuran,
                'jenis_barang'  => $request->jenis_barang
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $post
            ], 200);
        }
        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {

        // $upload = ImageBarang::findOrFail($id);

        //find post by ID
        $post = Post::findOrfail($id);
        $gambar = Post::where('id', $id)->first();
        $path = $gambar->path;
        if ($post) {
            if (Storage::exists($path)) {
                Storage::delete($path);
                $post->delete();
            }
            //delete post
            // $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post Deleted' . $path,
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }
    // public function getBarang()
    // {
    //     $barang = ImageBarang::latest()->get();

    //     //make response JSON
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'List Data Post',
    //         'data'    => $barang
    //     ], 200);
    // }
    ///image
    // public function upload(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'file' => 'required|mimes:jpg,jpeg,png|max:5000',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'error' => $validator->errors()
    //         ], 401);
    //     }

    //     if ($file = $request->file('file')) {
    //         $path = $file->store('Gambar/ListVilla');
    //         $name = $file->getClientOriginalName();

    //         $save = new ImageBarang();
    //         $save->name = $name;
    //         $save->path = $path;
    //         $save->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'success upload images',
    //             'file' => $file
    //         ]);
    //     }
    // }
    // public function remove($id)
    // {
    //     $gambar = ImageBarang::where('id', $id)->first();
    //     $path = $gambar->path;
    //     $upload = ImageBarang::findOrFail($id);

    //     if ($upload) {
    //         if (Storage::exists($path)) {
    //             Storage::delete($path);
    //             $upload->delete();
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => $path,
    //         ], 200);
    //     }
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Post Not Found',
    //     ], 401);
    // }
}
