<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    use HasFactory;

    // Mendefinisikan atribut yang dapat diisi secara massal
    protected $fillable = [
        'application_id', 
        'perubahan', 
        'tingkat_kepentingan', 
        'request_date',
        'request_date_note',
        'approval_date', 
        'approval_date_note',
        'uat_date', 
        'uat_date_note',
        'release_date', 
        'release_date_note',
        'version', 
        'target_release_date', 
        'target_release_date_note',
        'approval_status'
    ];

    // Mendefinisikan relasi Many-to-One ke model Application
    public function application()
    {
        // Sebuah perubahan dimiliki oleh satu aplikasi
        return $this->belongsTo(Application::class);
    }
}