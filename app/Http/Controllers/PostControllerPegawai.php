<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Validator;

class PostControllerPegawai extends Controller
{
    //
    public function index()
    {
        $post = Pegawai::latest()->get();

        //make response json
        return response()->json([
            'success' => true,
            'message' => 'List Pegawai',
            'data' => $post
        ], 200);
    }
    public function show($id)
    {
        //post by id
        $post = Pegawai::findOrFail($id);

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
            'nama_pegawai' => 'required',
            'posisi' => 'required',
            'alamat' => 'required',
            'umur' => 'required',
            'nik' => 'required',
            'gaji' => 'required',
        ]);

        //response error validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //masukin ke database
        $post = Pegawai::create([
            'nama_pegawai' => $request->nama_pegawai,
            'posisi' => $request->posisi,
            'alamat' => $request->alamat,
            'umur' => $request->umur,
            'nik' => $request->nik,
            'gaji' => $request->gaji
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
    public function update(Request $request, Pegawai $post, $id)
    {
        //set validation

        $input = $request->all();
        $validator = Validator::make($input, [
            'nama_pegawai' => 'required',
            'posisi' => 'required',
            'alamat' => 'required',
            'umur' => 'required',
            'nik' => 'required',
            'gaji' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post = Pegawai::findOrFail($id);

        if ($post) {
            $post->update([
                'nama_pegawai' => $request->nama_pegawai,
                'posisi' => $request->posisi,
                'alamat' => $request->alamat,
                'umur' => $request->umur,
                'nik' => $request->nik,
                'gaji' => $request->gaji
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
        $post = Pegawai::findOrFail($id);

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
