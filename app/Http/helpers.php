<?php
/**
	obtem o ip de quem acessa o sistema
	@return string ip
*/
function getIp()
{
 
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
 
        $ip = $_SERVER['HTTP_CLIENT_IP'];
 
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
 
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
 
    }
    else{
 
        $ip = $_SERVER['REMOTE_ADDR'];
 
    }
 
    return $ip;
}

function ufBrasil()
{
    return array("AC" => "Acre", "AL" => "Alagoas", "AM" => "Amazonas", "AP" => "Amapá", "BA" => "Bahia", "CE" => "Ceará", "DF" => "Distrito Federal", "ES" => "Espírito Santo", "GO" => "Goiás", "MA" => "Maranhão", "MT" => "Mato Grosso", "MS" => "Mato Grosso do Sul", "MG" => "Minas Gerais", "PA" => "Pará", "PB" => "Paraíba", "PR" => "Paraná", "PE" => "Pernambuco", "PI" => "Piauí", "RJ" => "Rio de Janeiro", "RN" => "Rio Grande do Norte", "RO" => "Rondônia", "RS" => "Rio Grande do Sul", "RR" => "Roraima", "SC" => "Santa Catarina", "SE" => "Sergipe", "SP" => "São Paulo", "TO" => "Tocantins");
}

/**
 * verifica se user é admin
 */
function isAdmin(\App\User $user)
{
    foreach($user->roles as $role){//admin
        if($role->name == 'admin') return true;
    }
    return false;
}

/**
 * @param $dmy dd/mm/yyyy
 */
function dataGravar($dmy)
{
    if(!$dmy){
        return null;
    }
    $data = explode('/', $dmy);
    $data = array_reverse($data);
    return implode('-', $data);
}

function dataExibir($ymd)
{
    if(!$ymd){
        return null;
    }
    $data = date_create($ymd);
    return date_format($data,"d/m/Y");
/*    $data = explode('-', $ymd);
    $data = array_reverse($data);
    return implode('/', $data);*/
}

/**
 * retorna o nome do tipo de documentos p usar na view
 */
function getNomeTipo($id){
    $tipos = [ 1 => 'comum', 2 => 'processo', 3 => 'declaracao', 4 => 'livro', 5 =>'lei' ];
    return array_get($tipos,$id);
}

/**
    limpa string de caractere especiais
    * @param  $string string a ser tratada
*/
function sanitizeString($string) {

        // matriz de entrada
        $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

        // matriz de saída
        $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );

        // devolver a string
        return str_replace($what, $by, $string);
    }
