<?php

namespace OSWP_Functions;

use Error\OSWP_Error;

trait OSWP_Functions{

    use OSWP_Error;

    public function __construct()
    {
    }

    public function __toString()
    {
    }

    /**
     * Global Function - return
     * @param bool   $success  Check Proccess || Misson Control (!)
     * @param mixed  $value    Return Value
     * @param string $message  Return Message Or Note        
     * @return object
     */
    public function _return($success, $value, $message)
    {
        if( !is_bool( $success ) )
        {
            self::returnError( 'First Parameter Only Boolean' );
        }
        
        if( strlen($message) >= 50 )
        {
            self::returnError( 'Message Max 50' );
        }

        return (object) array(
            'success'   => (bool) $success,
            'value'     => $value ? $value : $value,
            'message'   => (string) $message ? $message : '-',
        );
    }

    /**
     * Global Function - var_dump()
     * @param mixed $value  Will Display Value
     * @return object
     */
    public function _dump( $value )
    {
        if( empty( $value ) and !is_string( $value ) ) 
        {
           return  $this->_return( false , '' , 'Empty Value Or Not String' );
        }
        else {
            return $this->_return( true , var_dump( $value ) , 'True - '.__FUNCTION__.'' );
        }
        
    }

    /**
     * Global Function - _die()
     * @param string $text  Will Display Text  
     * @return object
     */
    public function _die(string $text)
    {
        if( empty( $text ) and !is_string( $text )) {
            return $this->_return( false , '' , 'Empty Value Or Not String' );
        }
        else{
            return $this->_return( true , die( $text ) , 'True - '.__FUNCTION__.'' );
        }
    }

    /**
     * Global Function - exit()
     * @return object
     */
    public function _exit()
    {
        return $this->_return( true , exit() , 'True _exit()' );
    }

    /**
     * With Enter Array Returning
     * @param array $array  Echo Array
     * @return object 
     */
    public function echoArray(array $array)
    {
        if( is_array( $array ) && !empty( $array ) )
        {
            foreach( $array as $a )
            {
                echo $a;
            }
            
            return $this->_return( true , $array , 'True echoArray()');
        }
        else
        {
            self::returnError( 'Only Array And Not Empty' );
        }
    }

    /**
     * Check Value Type
     * @param mixed $controlValue   Will Check Value
     */
    public function typeControl( $controlValue )
    {

        if( empty( $controlValue ) )
        {
            self::returnError( 'Fill The Blank - '.__FUNCTION__.'' );
        }
        else
        {
            switch( $controlValue )
            {
                case is_integer( $controlValue ) or is_int( $controlValue ):
                    return $this->_return(
                        true , (int) $controlValue , 'Value Is Integer - Int'
                    );
                    break;

                case is_string( $controlValue ):
                    return $this->_return(
                        true , (string) $controlValue , 'Value Is String'
                    );
                    break;

                case is_bool( $controlValue ):
                    return $this->_return(
                        true , (bool) $controlValue , 'Value Is Bool - Boolean'
                    );
                    break;

                case is_float( $controlValue ):
                    return $this->_return(
                        true , (float) $controlValue , 'Value Is Float'
                    );
                    break;

                case is_array( $controlValue ):
                    return $this->_return(
                        true , (array) $controlValue , 'Value Is Array'
                    );
                    break;
                
                case is_object( $controlValue ):
                    return $this->_return(
                        true , (object) $controlValue , 'Value Is Object'
                    );
                    break;

                case is_double( $controlValue ):
                    return $this->_return(
                        true , (double) $controlValue , 'Value Is Double'
                    );
                    break;

                case is_nan( $controlValue ):
                    return $this->_return(
                        true , $controlValue , 'Value Is NaN'
                    );
                    break;
                
                case is_numeric( $controlValue ):
                    return $this->_return(
                        true , $controlValue , 'Value Is Numeric'
                    );
                    break;

                default:
                    return self::returnError( 'Switch Case Error - '.__FUNCTION__.'' );
            }
        }
    }

}
