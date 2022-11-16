<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CghHorizontina extends Model
{
    use HasFactory;

    protected $fillable = [
        'ug01_nivel_agua',
        'ug01_tensao_fase_A',
        'ug01_tensao_fase_B',
        'ug01_tensao_fase_C',
        'ug01_corrente_fase_A',
        'ug01_corrente_fase_B',
        'ug01_corrente_fase_C',
        'ug01_tensao_excitacao',
        'ug01_corrente_excitacao',
        'ug01_frequencia',
        'ug01_potencia_ativa',
        'ug01_potencia_reativa',
        'ug01_potencia_aparente',
        'ug01_fp',
        'ug01_horimetro',
        'ug01_distribuidor',
        'ug01_velocidade',
        'ug01_acumulador_energia',
        'ug01_temp_fase_A',
        'ug01_temp_fase_B',
        'ug01_temp_fase_C',
        'ug01_temp_excitatriz',
        'ug01_temp_mancal_guia_ger',
        'ug01_temp_mancal_guia_tub',
        'ug01_temp_mancal_escora',
        'ug01_temp_oleo_UHRV',
        'ug02_nivel_agua',
        'ug02_tensao_fase_A',
        'ug02_tensao_fase_B',
        'ug02_tensao_fase_C',
        'ug02_corrente_fase_A',
        'ug02_corrente_fase_B',
        'ug02_corrente_fase_C',
        'ug02_tensao_excitacao',
        'ug02_corrente_excitacao',
        'ug02_frequencia',
        'ug02_potencia_ativa',
        'ug02_potencia_reativa',
        'ug02_potencia_aparente',
        'ug02_fp',
        'ug02_horimetro',
        'ug02_distribuidor',
        'ug02_velocidade',
        'ug02_acumulador_energia',
        'ug02_temp_fase_A',
        'ug02_temp_fase_B',
        'ug02_temp_fase_C',
        'ug02_temp_excitatriz',
        'ug02_temp_mancal_guia_ger',
        'ug02_temp_mancal_guia_tub',
        'ug02_temp_mancal_escora',
        'ug02_temp_oleo_UHRV',
        ];
}
