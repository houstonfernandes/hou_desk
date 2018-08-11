<?php
namespace App\Exceptions;

class NaoPodeExcluirException extends \Exception
{
    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message='Não pode excluir.', $code = 204, \Exception $previous = null) {        
        parent::__construct($message, $code, $previous);
    }
}
