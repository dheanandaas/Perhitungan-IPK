<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPK extends Model
{
    protected $table = 'tb_ipk';
    protected $primaryKey = 'id_ipk';

    protected $fillable = ['nim', 'semester', 'tahun', 'ips', 'ipk'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
