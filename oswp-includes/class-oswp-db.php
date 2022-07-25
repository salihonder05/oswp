<?php

namespace Class_DB;

define('HOST' , 'localhost');
define('DB_NAME', 'oswp');
define('DB_USER' , 'root');
define('DB_PASSWORD', '');

use Exception;
use PDO;
use PDOException;
use OSWP_Functions\OSWP_Functions;

class OSWP_DB extends OSWP_Functions{

    protected $connect;

    public function __construct()
    {
        if( $this->constantControl()->success === false )
        {
            parent::_die( 'OSWP_DB Constant Not Defined !' );
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
                "class"     => __CLASS__,
            );
        }
        else{
            return (object) array(
                "success"   => false,
                "error"     => 'OSWP_DB constant Not Defined !',
                "code"      => "err_oswpdb_constant",
                "class"     => __CLASS__,
            ); 
        }
    } 

    public function connection()
    {
        try{
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
        }
    }

    public function tableControl(string $table)
    {
        $q = $this->connect->prepare('SHOW TABLES');
        $q->execute();
        $t = $q->fetchAll();

        foreach( $t as $tt ){

            foreach( $tt as $r ){

                if( $r == $table )
                {
                    return (object) array(
                        'success'   => true,
                        'value'     => $r,
                        'message'   => 'Table Found !',
                    );
                }
                else
                {
                    continue;
                }
            }
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
            return (object) array(
                'success'   => false,
                'error'     => 'DB Not Table Inside',
            );
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
            parent::_die( 'OSWP_DB Table Not Found' );
        }
    }

}

?>