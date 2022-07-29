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

    public function globalFunc()
    {
        return $this;
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
            return $this->_return__die( false , $value , 'First Parameter Only Boolean - '.__FUNCTION__.'()' );
        }
        
        if( strlen($message) >= 50 )
        {
            return $this->_return__die( false , $value , 'Message Max 50 - '.__FUNCTION__.'()' );
        }

        return (object) array(
            'success'   => (bool) $success,
            'value'     => $value ? $value : $value,
            'message'   => (string) $message ? $message : '-',
        );
    }

    public function _return__die($success , $value , $message)
    {
        /**
         * There is Error
         */
        if( $this->_return( $success , $value , $message )->success === false )
        {
            return $this->_return( $success , $value , $message );
        }
        
        if( $this->_return( $success , $value , $message )->success === true )
        {
            return $this->_return( $success , $value , $message );
            
        }
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
            $this->returnError( $text );
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
            $this->returnError( 'Only Array And Not Empty' );
        }
    }

    public function checkCountArray(array $arr)
    {
        if( empty( is_array( $arr ) ) )
        {
            return $this->_return( false , '' , 'Only Array - '.__FUNCTION__.'' );
        }

        if( count( $arr ) < 0 )
        {
            return $this->_return( false , count( $arr ) , 'Array Count Can\'t Small Be Zero (0)' );
        }

        return $this->_return( true , count( $arr ) , 'True - '.__FUNCTION__.'' );
    }


    /**
     * @param string $text          Escape HTML Enter Text
     * @param string $regularWrite  Select Type
     *   - left : Put space text end 
     *   - right: Put space text start
     *   - none : Not put space
     */
    public function _escape_html( $text , $regularWrite = 'none' )
    {
        $encoding = array(
            'UTF-8',
        );

        $text = strip_tags( $text );
        $exp_text = explode( " " , $text );

        if( $this->checkCountArray( $exp_text )->success === false )
        {
            return $this->_return( false , $exp_text , 'Array Count Can\'t Be Zero (0)' );
        }

        foreach( $exp_text as $key => $e )
        {
            if( count( $exp_text ) < 0 )
            {
                return $this->_return( false , $exp_text , 'Array Count Can\'t Be Zero (0)' );
            }

            if( !empty( $e ) )
            {
                continue;
            }
            else
            {
                unset($exp_text[ $key ]);
            }
        }

        $regularArr = array(); // Regular For Array Key Number
        $resultValue = ""; // return for last text

        foreach( $exp_text as $key => $val )
        {
            array_push( $regularArr , $val );
        }

        if( $regularWrite === 'none' )
        {
            foreach( $regularArr as $value )
            {
                $resultValue .= $value; 
            }
            return $this->_return( true , $resultValue , 'True' );
        }

        /**
         * This Here Only Put Space Left
         */
        if( $regularWrite === 'left' )
        {
            $resultArr = array(); // LAST REGULAR AND REGULAR VALUE ARRAY

            foreach( $regularArr as $key => $value )
            {

                if( $key === count( $regularArr ) - 1 )
                {
                    $resultValue .= $value;
                    continue;
                }

                if( isset( $value ) )
                {
                    $value .= " ";
                    $resultValue .= $value;
                    array_push( $resultArr , $value );
                }
                
            }
            
            return $this->_return( true , $resultValue , 'True' );
        }

        /**
         * This Here Only Put Space Right
         */
        if( $regularWrite === 'right' )
        {
            $resultArr = array(); // LAST REGULAR AND REGULAR VALUE ARRAY

            foreach( $regularArr as $key => $value )
            {

                if( $key === ( count( $regularArr ) - count( $regularArr ) ) )
                {
                    $resultValue .= $value;
                    continue;
                }

                if( isset( $value ) )
                {
                    $value = " ".$value;
                    $resultValue .= $value;
                    array_push( $resultArr , $value );
                }
                
            }
            
            return $this->_return( true , $resultValue , 'True' );
        }

    }

    /**
     * Text Encoding Controller
     * @param string $text     Check Encoding Text
     * @param array $encoding  Check Encoding Types ( UTF-8 , ASCII esc. )
     */
    public function encodingController( $text , $encoding )
    {
        if( empty( is_string( $text ) ) )
        {
            return $this->_die( 'Only String Parameter - '.__FUNCTION__.'()' );
        }

        if( empty( is_array( $encoding ) ) )
        {
            return $this->_die( 'Only Array Parameter - '.__FUNCTION__.'()' );
        }

        $encodingArr = $encoding;

        if( mb_detect_encoding( $text , $encodingArr ) === $encodingArr[ 0 ] )
        {
            return $this->_return( true , $text , 'True - '.__FUNCTION__.'()' );
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
            $this->returnError( 'Fill The Blank - '.__FUNCTION__.'' );
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
                    return $this->returnError( 'Switch Case Error - '.__FUNCTION__.'' );
            }
        }
    }

}
