<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadServicio extends Model
{
    use HasFactory;

    protected $table = 'unidad_servicios';

    protected $fillable = ['user_id', 'empresa_id', 'colaborador_id', 'nombre'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class, 'colaborador_id'); // asegúrate del nombre del campo FK
    }
}
