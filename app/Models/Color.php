<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
// Color.php
public function barang()
{
    return $this->belongsTo(Barang::class);
}

}
