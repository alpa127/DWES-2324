<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido_Producto extends Model
{
    use HasFactory;
    

    function pedido(){
        //Si seguimod la convención de nombres
        return $this->belongsTo(Pedido::class);
    }

    function producto(){
        //Si NO seguimos la convención de nombres
        return $this->belongsTo(Pedido::class, 'producto','id');
    }
}
