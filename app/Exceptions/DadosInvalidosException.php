<?php
namespace App\Exceptions;

class DadosInvalidosException extends \Exception
{
    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message='Dados inválidos.', $code = 422, \Exception $previous = null) {        
        parent::__construct($message, $code, $previous);
    }
}
