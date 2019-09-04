<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table="category";
    protected $primaryKey = "id_category";

    public function product(){
        return $this->hasMany("App\Produk",'id_category');
    }
}
