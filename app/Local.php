<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locais';
    protected $fillable = [
        'nome', 'nome_fantasia', 'cnpj', 'inep', 'endereco', 'numero', 'bairro', 'cidade', 
        'uf','ponto_ref', 'cep', 'complemento', 'tel', 'cel', 'email', 'obs', 'ativo','tecnico_id'
    ];
    
    protected $attributes = [//valores default
    ];
    
    /**
     * busca setores
     */
    public function setores()
    {
        return $this->hasMany(Setor::class)->orderBy('nome');;
    }
    
    /**
     * busca usuarios
     */
    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
    
    public function tecnico(){
        return $this->belongsTo(User::class, 'tecnico_id');
    }
}
