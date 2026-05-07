<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'nha_cung_cap';
    protected $primaryKey = 'id_ncc';
    protected $fillable = ['ten_ncc','dia_chi','sdt','email','ghi_chu'];
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class, 'id_ncc', 'id_ncc');
    }
}