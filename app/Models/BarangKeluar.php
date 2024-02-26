<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluar';
    protected $fillable = [
        'no',
        'dist_id',
        'nama_customer',
        'barang_id',
        'qty',
        'tanggal',
        'total',
        'user_id',
        'status',
        'harga_jual'
    ];
    protected $with = ['barangs','distributor', 'user'];

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class, 'dist_id', 'id');
    }

    function barangs()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    function barang()
    {
        return $this->belongsToMany(Barang::class, 'distributor_has_barang_keluar', 'barang_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
