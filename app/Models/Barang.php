<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = [
        'nama',
        'dist_id',
        'harga',
        'stok_barang',
        'qty',
        'harga_satuan',
        'user_id',
        'type'
    ];
    protected $with = ['distributor', 'user'];

    public function distributor()
    {
        return $this->belongsToMany(Distributor::class, 'distributor_has_barang', 'dist_id', 'barang_id');
    }

    function distributorBarangKeluar()
    {
        return $this->belongsToMany(Distributor::class, 'distributor_has_barang_keluar', 'dist_id', 'barang_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
