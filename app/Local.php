<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locais';
    protected $fillable = [
        'nome', 'nome_fantasia', 'cnpj', 'inep', 'endereco', 'numero', 'bairro', 'cidade', 
        'uf','ponto_ref', 'cep', 'complemento', 'tel', 'cel', 'email', 'obs', 'ativo'
    ];
    
    protected $attributes = [//valores default
    ];
    
    /**
     * busca setor
     */
    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }
    
}
