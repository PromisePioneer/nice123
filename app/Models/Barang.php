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

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class, 'dist_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
