<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListVilla extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_villa', 'nama_pemilik', 'luas_villa', 'lokasi_villa', 'kawasan'
    ];
}
