<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    protected $table = 'danh_muc';
    protected $primaryKey = 'id_danh_muc';
    protected $fillable = ['ten_danh_muc', 'mo_ta'];
    public $timestamps = false;
}