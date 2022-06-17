<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reporting_log extends Model
{
    use HasFactory;
    protected $table = 'reporting_log';
    protected $fillable = [
      'reporting_id',
      'kode',
      'tgl_buat',
      'status',
      'keterangan',
      'perusahaan',
      'nilai_kontrak',
    ];

}
