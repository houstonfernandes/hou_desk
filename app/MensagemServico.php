<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensagemServico extends Model
{
    protected $table = 'mensagens_servico';
    protected $fillable = [
        'user_id', 'servico_id', 'situacao', 'mensagem',
    ];
    protected $attributes = [
        'situacao' => 0
    ];
        
    /**
     * obtem o user
     * */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    /**
     * obtem o servico
     * */
    public function servico()
    {
        return $this->belongsTo('App\Servico');
    }    
}
