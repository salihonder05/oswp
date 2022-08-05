<?php

namespace Class_DB;

require 'version.php';

define('HOST' , 'localhost');
define('DB_NAME', 'oswp');
define('DB_USER' , 'root');
define('DB_PASSWORD', '');

use Exception;
use PDO;
use PDOException;
use OSWP_Functions\OSWP_Functions;

class OSWP_DB{

    use OSWP_Functions;

    protected $connect;

    public function __construct()
    {
        global $oswp_php_version;

        if( !$this->controlPHPVersion() )
        {
            $this->returnError( 'MIN PHP VERSION BE '.$oswp_php_version.'' );
            $this->_die( 'MIN PHP VERSION BE '.$oswp_php_version.'' );
        }

        if( $this->constantControl()->success === false )
        {
            $this->returnError( 'OSWP_DB Constant Not Defined !' );
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

            return $this->_return( true , '' , 'OSWP_DB - There is Defined(s)' );
        
        }
        else
        {
            $this->returnError( 'OSWP_DB Constant Not Defined(s)' ); 
            $this->_die( 'OSWP_DB Constant Not Defined(s)' );
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
            $this->returnError( $e->getMessage() ); 
        }
    }

    /**
     * Client PHP Version Control
     * @return object
     */
    public function controlPHPVersion()
    {
        global $oswp_php_version;

        $client_format = number_format( (double) PHP_VERSION , 1 );
        $oswp_format = number_format( (double) $oswp_php_version , 1);
        
        if( $client_format < $oswp_format)
        {
            $this->returnError( 'MIN PHP VERSION BE '.$oswp_format.'' );
            $this->_die( 'MIN PHP VERSION BE '.$oswp_format.'' );
        }

        if( $client_format >= $oswp_format )
        {
            return (double) $client_format;
        }
        
    }

    /**
     * Table Name Control
     * @param string $table  Enter Existing DB Table Name
     * @return object
     */
    public function tableControl(string $table)
    {
        if( is_string( $table ) )
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

                        return $r;

                    }
                }
            }

            if($temp === $temp)
            {
                $this->returnError(
                    ' \' '.$table.' \' Table Not Found' 
                );

                return $this->_return(
                    false , '' , '\' '.$table.' \' Table Not Found!'
                );
            }
        }
        else
        {
            return $this->_return(
                false , '' , 'Parameter Not String'
            );
        }
    }

    /**
     * Get Existing DataBase Tables
     * @return object 
     */
    public function getTableAll()
    {
        $q = $this->connect->prepare('SHOW TABLES');
        $q->execute();
        $t = $q->fetchAll();

        $names = array();

        if(empty( $t ) or $t <= 0) 
        {
            $this->returnError( '(OSWP_DB) Veritabanı içerisinde tablo bulunamıyor! ' ); 
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

    /**
     * Enter Table Name Control After Get Table Name
     * @param string $table     Will Check Table Name
     * @return object 
     */
    public function getTableName(string $table)
    {
        if( $this->tableControl( $table )->success === true )
        {
            return $this->tableControl( $table )->value;
        }
        else
        {
            $this->returnError( '(OSWP_DB) Tablo İsmi Yok!' ); 
        }
    }


    /**
     * Column Name Control
     * @param string $table     Get Table Name
     * @param string $column    Get Check Column Name
     * @return object
     */
    public function columnControl(string $table, string $column)
    {
        if( $this->tableControl( $table )->success === false )
        {
            $this->_die( 'Table Not Found!' );
        }

        if( 
            is_string( $column ) and
            is_string( $table )  and 
            !empty( $table )     and
            !empty( $column ) 
        ){
            $process = $this->connect->prepare('DESCRIBE '.$table.'');
            $process->execute();
            $result = $process->fetchAll();

            $columnsArr = array();
            
            foreach( $result as $r )
            {
                array_push( $columnsArr , $r['Field'] );
            }

            if( in_array( $column , $columnsArr ) )
            {
                return $column;
            }
            else
            {
                $this->returnError( ' \' '.$column.' \' Column Not Found In \' '.$table.' \' Table' );
            }            
        }
        else
        {
            $this->returnError( 'Value Not String Or Empty!' );
        }
    }

    /**
     * Table Or Tables Get Row Numbers
     * 
     * @param string $table  Enter Table Name
     * @param string $vote   Enter single , all
     * 
     * single -> Only Enter Table Name  
     * all    -> MYSQL Get All Table Row        
     */
    public function getTotalRow( $table , $vote = 'single')
    {

        /**
         * Hold Total Table Name And Row Number
         */
        $getAllTableRow  = array();

        if(  is_string( $table ) )
        {
            if( $this->tableControl( $table )->success === true )
            {
                if( mb_strtolower( $vote ) == 'single' )
                {
                    $process = $this->connect->prepare(
                        'SELECT COUNT(*) FROM '.$table.''
                    );
                    $process->execute();
                    $result = $process->fetchColumn();

                    if( isset( $result ) )
                    {
                        return $result;
                    }
                    else
                    {
                        $this->_die( 'FetchColumn Isset Error' );
                    }
                }
                else if( mb_strtolower( $vote ) == 'all' )
                {
                    $process = $this->connect->prepare(
                        'SELECT 
                            table_name, 
                            table_rows
                         FROM 
                            information_schema.tables'
                    );
                    $process->execute();
                    $result = $process->fetchAll();

                    if( isset( $result ) )
                    {
                        foreach( $result as $r )
                        {
                            array_push(
                                $getAllTableRow, 
                                array(
                                    $r['table_name'] => $r['table_rows']
                                )
                            );
                        }

                        return $getAllTableRow;
                    }
                    else
                    {
                        $this->_die( 'FetchColumn Isset Error' );
                    }
                }
                else
                {
                    $this->_die( 'Only use \'single\' and \'all\'' );
                }
            }
            else
            {
                $this->_die( 'Table Not Found!' );
            }
        }

    }

}

?>