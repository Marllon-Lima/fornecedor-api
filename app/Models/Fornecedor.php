<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $fillable = [
        'nome',
        'documento',
        'tipo',
        'nome_empresa',
        'email',
        'telefone',
        'endereco',
    ];
}
