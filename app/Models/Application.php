<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    // Mendefinisikan atribut yang dapat diisi secara massal
    protected $fillable = ['nama', 'fungsi', 'pengguna', 'pemilik', 'pengembang', 'no_kepdir'];

    // Mendefinisikan relasi One-to-Many ke model Change
    public function changes()
    {
        // Sebuah aplikasi dapat memiliki banyak perubahan
        return $this->hasMany(Change::class);
    }
}