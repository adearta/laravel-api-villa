<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\API;

use App\Models\Image;
use App\Http\Controllers\Controller;
use Doctrine\DBAL\Driver\IBMDB2\Result;
use Doctrine\Inflector\Rules\Ruleset;
// use Validator,Redirect,Response,File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ImageController extends Controller
{
    //
    public function upload(Request $request)
    {
        //melakukan validasi untuk mengecek format dan ukuran gambar
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpg,jpeg,png|max:5000',
        ]);
        //jika gagal divalidasi
        if ($validator->fails()) {
            //kembalikan respon json berupa error  valiidasi
            return response()->json(['error' => $validator->errors()], 401);
        }

        //cek jika ada request apakah sudah benar nama pengaksesnya "file"
        if ($file = $request->file('file')) {
            //membuat path dengan memanggil method store untuk menyimpa file pada folder dengan nama pubic/files
            $path = $file->store('public/files');
            // $name = $file->getClientOriginalName();

            //store your file into directory and db
            //instansiasi variable unutk menipan data melalui model
            $save = new Image();
            //model memanggil kolom name unutk memasukkan nama file
            $save->name = $file;
            //model memanggil kolom path untuk memasukka data path dari file
            $save->path = $path;
            //kemudian model memanggil method save untuk menyimpan data
            $save->save();

            //setelah selesai berikan respon berupa json
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                //file adalah data
                "file" => $file
            ]);
        }
    }
}
