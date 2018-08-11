<?php
namespace App\Exceptions;

class ProductNotFoundException extends \Exception
{
    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message='Produto não encontrado.', $code = 404, \Exception $previous = null) {
        // código        
        // garante que tudo está corretamente inicializado
        
        parent::__construct($message, $code, $previous);
    }
    
    // personaliza a apresentação do objeto como string
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
    public function notFound($id) {
        return "Produto \"". $id . "\" não encontrado.";
    }
}
