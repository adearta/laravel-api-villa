<?php

namespace App\Http\Controllers;

use App\Models\ListVilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostControllerListVilla extends Controller
{
    //
    public function index()
    {
        $post = ListVilla::latest()->get();

        //make response json
        return response()->json([
            'success' => true,
            'message' => 'List Villa',
            'data' => $post
        ], 200);
    }
    public function show($id)
    {
        //post by id
        $post = ListVilla::findOrFail($id);

        //make response
        return response()->json([
            'success' => true,
            'message' => 'id ditemukan',
            'data' => $post
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
        //validasi
        $validator = Validator::make($request->all(), [
            'nama_villa' => 'required',
            'nama_pemilik' => 'required',
            'luas_villa' => 'required',
            'lokasi_villa' => 'required',
            'kawasan' => 'required'
        ]);

        //response error validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //masukin ke database
        $post = ListVilla::create([
            'nama_villa' => $request->nama_villa,
            'nama_pemilik' => $request->nama_pemilik,
            'luas_villa' => $request->luas_villa,
            'lokasi_villa' => $request->lokasi_villa,
            'kawasan' => $request->kawasan
        ]);

        //pesan berhasil
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'data berhasil di buat',
                'data' => $post
            ], 201);
        }
        //pesan gagal
        else {
            return response()->json([
                'succes' => false,
                'message' => 'data gagal di buat'
            ], 409);
        }
    }
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, ListVilla $post, $id)
    {
        //set validation

        $input = $request->all();
        $validator = Validator::make($input, [
            'nama_villa' => 'required',
            'nama_pemilik' => 'required',
            'luas_villa' => 'required',
            'lokasi_villa' => 'required',
            'kawasan' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post = ListVilla::findOrFail($id);

        if ($post) {
            $post->update([
                'nama_villa' => $request->nama_villa,
                'nama_pemilik' => $request->nama_pemilik,
                'luas_villa' => $request->luas_villa,
                'lokasi_villa' => $request->lokasi_villa,
                'kawasan' => $request->kawasan
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $post
            ], 200);
        }
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
        //temukan id 
        $post = ListVilla::findOrFail($id);

        if ($post) {
            //hapus 
            $post->delete();

            //kembalikan pesan sukses
            return response()->json([
                'success' => true,
                'message' => 'data berhasil dihapus',

            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan'
            ], 400);
        }
    }
}
