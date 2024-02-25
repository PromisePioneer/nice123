<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';
    protected $fillable = [
        'no',
        'dist_id',
        'barang_id',
        'qty',
        'tanggal',
        'total',
        'user_id',
        'status'
    ];

    protected $with = ['distributor', 'user'];

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class, 'dist_id', 'id');
    }

    function barang()
    {
        return $this->belongsToMany(Barang::class, 'distributor_has_barang', 'barang_id', 'barangMasuk_id');
    }

    function barangs()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
