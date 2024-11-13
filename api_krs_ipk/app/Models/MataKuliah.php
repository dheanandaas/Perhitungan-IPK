<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'tb_mk';
    protected $primaryKey = 'id_mk';

    protected $fillable = ['nama_mk', 'sks'];

    public function krs()
    {
        return $this->hasMany(KRS::class, 'id_mk', 'id_mk');
    }
}
