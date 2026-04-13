<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Brand extends Model
{
    protected $table = 'thuong_hieu';
    protected $primaryKey = 'id_thuong_hieu';
    protected $fillable = ['ten_thuong_hieu','quoc_gia','logo'];
    public $timestamps = false;
}