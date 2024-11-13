<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'tb_mhs';
    protected $primaryKey = 'nim';
    public $incrementing = false;

    protected $fillable = ['nim', 'nama', 'ips', 'ipk'];

    public function krs()
    {
        return $this->hasMany(KRS::class, 'nim', 'nim');
    }

    public function ipk()
    {
        return $this->hasMany(IPK::class, 'nim', 'nim');
    }
}
