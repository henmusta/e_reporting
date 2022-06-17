<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reporting extends Model
{
    use HasFactory;
    protected $table = 'reporting';
    protected $fillable = [
      'paket_id',
      'kode',
      'tgl_buat',
      'nama_paket',
      'perusahaan',
      'status',
      'nilai_kontrak',
      'keterangan',
    ];

}
