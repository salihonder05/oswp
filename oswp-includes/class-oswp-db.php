<?php

namespace Class_DB;

define('HOST' , 'localhost');
define('DB_NAME', 'oswp');
define('DB_USER' , 'root');
define('DB_PASSWORD', '');

use Exception;
use PDO;
use PDOException;
use Error\OSWP_Error;

class OSWP_DB{

    use OSWP_Error;

    protected $connect;

    public function __construct()
    {
        if( $this->constantControl()->success === false )
        {
            $this->_die( 'OSWP_DB Constant Not Defined !' );
        }

        $this->connection();
    }

    /**
     * Check DB Constant
     * Only Using OSWP_DB Class
     */

    private function constantControl()
    {
        if(
            defined( 'HOST' )     &&
            defined( 'DB_NAME' )  &&
            defined( 'DB_USER' )  &&
            defined( 'DB_PASSWORD' )
        ){
            return (object) array(
                "success"   => true,
                "error"     => 'OSWP_DB - There is Defined(s)',
                "code"      => "",
            );
        }
        else
        {
            OSWP_Error::returnError( 'OSWP_DB Constant Not Defined(s)' ); 
        }
    } 

    public function connection()
    {
        try
        {
            $this->connect = new PDO(
                'mysql:host=' . HOST . ';dbname=' . DB_NAME . ';',
                DB_USER,
                DB_PASSWORD,  
            );
            $this->connect->exec('set name utf8');
            $this->connect->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            return $this->connect;
        }
        catch (\PDOException $e){
            echo $e->getMessage();
            OSWP_Error::returnError( $e->getMessage() ); 
        }
    }

    public function tableControl(string $table)
    {
        $q = $this->connect->prepare('SHOW TABLES');
        $q->execute();
        $t = $q->fetchAll();

        $temp = 0;

        foreach( $t as $tt ){

            foreach( $tt as $r ){

                if( $r == $table )
                {   
                    $temp++;
                    return (object) array(
                        'success'   => true,
                        'value'     => $r,
                        'message'   => 'Table Found !',
                    );
                }
            }
        }

        if($temp === $temp)
        {
            self::returnError(
                '(OSWP_DB) Böyle bir isimde tablo bulunamadı! Eğer ki amacınız tablo kontrolü değil ise dikkate almayın!' 
            );
        }
    }

    public function getTableAll()
    {
        $q = $this->connect->prepare('SHOW TABLES');
        $q->execute();
        $t = $q->fetchAll();

        $names = array();

        if(empty( $t ) or $t <= 0) 
        {
            OSWP_Error::returnError( '(OSWP_DB) Veritabanı içerisinde tablo bulunamıyor! ' ); 
        }
        else 
        {
            for($i=0; $i < count($t); $i++)
            {
                $f1 = $t[$i];

                for($j = 0; $j < count($f1) - 1; $j++)
                {
                    //get names
                    $result = $f1[$j];
                    array_push($names , $result);
                }
            }
        }
        return $names;
        
    }

    public function getTableName(string $table)
    {
        if( $this->tableControl( $table )->success === true )
        {
            return $this->tableControl( $table )->value;
        }
        else
        {
            OSWP_Error::returnError( '(OSWP_DB) Tablo İsmi Yok!' ); 
        }
    }

}

?>