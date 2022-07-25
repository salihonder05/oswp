<?php

namespace OSWP_Functions;

class OSWP_Functions{

    public function __construct()
    {
    }

    public function __toString()
    {
    }

    public function _dump( $value ){
        if( empty( $value ) ) {
            return (object) [
                "success"   => false,
                "error"     => 'Empty Value !',
                "code"      => "err_oswp_functions_1",
                "class"     => __CLASS__,
            ];
        }
        else {
            return var_dump( $value );
        }
        
    }

    public function _die(string $text){
        if( empty( $text ) ) {
            return (object) [
                "success"   => false,
                "error"     => 'Empty Value !',
                "code"      => "err_oswp_functions_2",
                "class"     => __CLASS__,
            ];
        }
        else{
            return die( $text );
        }
    }

    public function _exit(){
        return exit( );
    }

}
