<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = "product";

    protected $primaryKey = "id_product";

    public function category(){
        return $this->belongsTo('App\Kategori','id_category');
    }
}
