<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ConteudoProgramatico extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id',
        'acao_id',
        'ministrante',
        'cpf',
        'email',
        'ementa',
        'data_inicio',
        'data_termino',
        'carga_horaria',
        'certificado_cod',
        'certificado_data',
        'certificado_status',
    ];

    public function Acao() {
        return $this->belongsTo(Acao::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
