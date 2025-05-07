<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaDepartamento extends Model
{
    use HasFactory;

    protected $table = 'area_departamentos';

    protected $fillable = ['nombre', 'unidad_servicio_id'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function unidad()
    {
        return $this->belongsTo(UnidadServicio::class, 'unidad_servicio_id');
    }
}
