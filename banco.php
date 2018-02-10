<?php
/*
O QUE ACHA DE DEIXAR ESSA PARTA ALTERAVEL PARA QUE O SISTEMA POSSSA
SER USADOS POR QUALQUER PESSOA?
*/


class Banco
{
    private static $dbNome;
    private static $dbHost;
    private static $dbUsuario;
    private static $dbSenha;
    
    private static $cont = null;
    
    /*public function __construct() 
    {
        die('A função Init nao é permitido!');
    }*/
    
    /*DESSA FORMA*/
    public function __construct($dbHost,$dbUsuario,$dbSenha,$dbNome){
        self::$dbHost       = $dbHost;
        self::$dbUsuario    = $dbUsuario;
        self::$dbSenha      = $dbSenha;
        self::$dbNome       = $dbNome;
    }
    

    /*
    SE QUISER FAZER UMA API PARA MUITAS PESSOAS, O QUE ACHA DE
    FAZER MAIS FUNCTION PRA CONECTAR AI A PESSOA ESCOLHE COMO TRABALHAR
    COM "PDO ou MYSQL"
    */

    public function conectaMysqli(){
        if(!self::$cont):
            $conect = mysqli_connect(self::$dbHost,self::$dbUsuario,self::$dbUsuario,self::$dbSenha);
            if(!conect):
                echo "erro ao conectar com mysql";
            else:
                self::$cont = $conect;
                wreturn self::$cont;
            endif;
        else:
            return self::$cont;
        endif;
    }

    public static function conectar()
    {
        if(null == self::$cont)
        {
            try
            {
                self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbNome, self::$dbUsuario, self::$dbSenha); 
            }
            catch(PDOException $exception)
            {
                die($exception->getMessage());
            }
        }
        return self::$cont;
    }
    
    public static function desconectar()
    {
        self::$cont = null;
    }
}

?>
