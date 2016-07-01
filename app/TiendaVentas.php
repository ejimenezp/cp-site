<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiendaVentas extends Model
{
    //
    public function desc0()
    {
        return $this->hasOne('App\TiendaArticulo', 'id', 'linea0');
    }

    public function desc1()
    {
        return $this->hasOne('App\TiendaArticulo', 'id', 'linea1');
    }

    public function desc2()
    {
        return $this->hasOne('App\TiendaArticulo', 'id', 'linea2');
    }

    public function desc3()
    {
        return $this->hasOne('App\TiendaArticulo', 'id', 'linea3');
    }

}
