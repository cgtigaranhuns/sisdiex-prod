<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Acao extends Model
{
    use HasFactory, LogsActivity ;

    protected $fillable = [

            'titulo',
            'user_id',
            'area_conhecimento_id',
            'area_tematica_id',
            'area_extensao_id',
            'tipo_acao_id',
            'atividade_relativa',
            'publico_alvo',
            'vagas_total',
            'vagas_externa',
            'local',
            'data_inicio',
            'data_encerramento',
            'hora_inicio',
            'hora_encerramento',
            'dias_semana',
            'carga_hr_semanal',
            'carga_hr_total',
            'periocidade',
            'modalidade',
            'turno',
            'duracao_aula',
            'criterio_aprovacao',
            'frequencia_minima',
            'media_aprovacao',
            'forma_avaliacao',
            'requisitos',
            'justificativa',
            'objetivo_geral',
            'objetivo_especifico',
            'metodologia',
            'bibliografia',
            'outras_informacoes',
            'status',
            'status_justifique',
            'data_inicio_inscricoes',
            'data_fim_inscricoes',
            'doacao',
            'tipo_doacao',
            'cota',
            'cota_servidor',
            'cota_discente',
            'cota_externo',
            'status_comprovante',
            'descricao_comprovante',

    ];

    protected $casts = [
        'dias_semana' => 'array',
    ];

    public function User() {
        return $this->belongsTo(User::class);
    }

    public function AreaConhecimento() {
        return $this->belongsTo(Area::class);
    }

    public function AreaTematica() {
        return $this->belongsTo(Area::class);
    }

    public function AreaExtensao() {
        return $this->belongsTo(Area::class);
    }

    public function TipoAcao() {
        return $this->belongsTo(TipoAcao::class);
    }

    public function Inscricao() {
        return $this->hasMany(Inscricao::class);

    }

    public function ConteudoProgramatico() {
        return $this->hasMany(ConteudoProgramatico::class);

    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
