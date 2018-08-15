<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MeuResetSenha;
use phpDocumentor\Reflection\Types\This;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','is_admin',
        'endereco', 'numero', 'bairro', 'cidade', 'uf', 'cep', 'complemento','tel', 'cel'
    ];
    
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    /**
     * lista pedidos do user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos(){
        return $this->hasMany('App\Pedido');
    }
    
    /**
     * busca o local do user
     */
    public function local()
    {
        return $this->belongsTo('App\Local');
    }

    /*
     * Papeis do user
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
   
    public function hasPermission($permission)
    {
        if($this->is_admin)
            return true;
        return $this->hasAnyRoles($permission->roles);
    }
    
    /**
     * verifica se os papeis da permission existem para o user
     * @return boolean
     * */
    public function hasAnyRoles($roles)
    {
        foreach($this->roles as $role){//admin
            if($role->name == 'admin') 
                return true;            
        }
        
        if( is_array($roles) || is_object($roles)){
            //The intersect method removes any values from the original collection that are not present in the given array or collection. The resulting collection will preserve the original collection's keys:
            return !! $roles->intersect($this->roles)->count(); //retorna true se restar pelo menos 1 nas regras do user
        }
        return $this->roles->contains('name', $roles->name);
    }
    
    public function sendPasswordResetNotification($token) {
        $this->notify(new MeuResetSenha($token));
    }
}
