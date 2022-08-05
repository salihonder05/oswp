<?php

namespace OSWP_Functions;

use Error\OSWP_Error;
use Link\OSWP_Links;

trait OSWP_Functions{

    use OSWP_Error;
    use OSWP_Links;

    /**
     * Public Timer Variable
     */
    public $timer_start;
    public $timer_end;
    public $timer_total;

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
            die( $text );
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
            
            return $array;
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

        return count( $arr );
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

        /**
         * This Here Not Space
         */
        if( $regularWrite === 'none' )
        {
            foreach( $regularArr as $value )
            {
                $resultValue .= $value; 
            }
            return $resultValue;
        }

        /**
         * This Here Only Put Space Left
         */
        if( $regularWrite === 'right' )
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
            
            return $resultValue;
        }

        /**
         * This Here Only Put Space Right
         */
        if( $regularWrite === 'left' )
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
            
            return $resultValue;
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

        if( mb_detect_encoding( $text , $encodingArr ) === $encoding )
        {
            return $text;
        }
    }

    /**
     * Micro Time Starter
     */
    public function timerStart()
    {
        $this->timer_start = microtime(true);
        return true;
    }

    /**
     * Micro Timer End
     * @param bool $view    Time View
     */
    public function timerEnd( $view = false )
    {
        if( !is_bool( $view ) )
        {
            $this->_die( 'Parameter Only Boolean!' );
        }

        $this->timer_end = microtime(true);
        $this->timer_total = number_format( (double) ( $this->timer_end - $this->timer_start ) , 2 );

        if( $view === true )
        {
            echo $this->timer_total;
        }
        return $this->timer_total;
    }

    /**
     * Check Function
     */
    public function is_function( $function )
    {
        if( !is_callable( $function ) )
        {
            $this->_die( ' \' '.$function.' \' ' . ' Value Is Not Function' );
        }

        if( is_callable( $function ) )
        {
            return true;
        }
    }

    /**
     * Execute Code But With Delay
     */
    public function withExecDelay( $function , int $delay )
    {
        $this->is_function( $function );

        if( !is_int( $delay ) or !is_numeric( $delay ) )
        {
            $this->_die( 'Delay Not Int || Numeric' );
        }

        if( $delay <= 0 )
        {
            $this->_die( 'Delay Can\'t Be Small Zero (0)' );
        }

        if( $delay >= 1000 )
        {
            $this->_die( 'Enter Small Number! 1 , 2 , 3 etc..' );
        }
        
        $temp = 1;
        while( $temp <= $delay )
        {
            if( $temp > $delay )
            {
                $this->_die( 'While Loop Forever' );
            }

            if( $delay > $delay )
            {
                $this->_die( 'While Loop Forever' );
            }

            $function;
            sleep(1);
            $temp++;
        }
    }

    /**
     * Every Second Execute Function
     */
    public function setInterval( $function , int $second )
    {
        $this->is_function( $function );

        if( !is_int( $second ) or !is_numeric( $second ) )
        {
            $this->_die( 'Delay Not Int || Numeric' );
        }

        if( $second <= 0 )
        {
            $this->_die( 'Delay Can\'t Be Small Zero (0)' );
        }

        if( $second >= 1000 )
        {
            $this->_die( 'Enter Small Number! 1 , 2 , 3 etc..' );
        }
        
        while( true )
        {
            $function;
            sleep($second);
        }
    }

}
