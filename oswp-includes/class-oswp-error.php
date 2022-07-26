<?php 

namespace Error;

use OSWP_Functions\OSWP_Functions;

trait OSWP_Error{

    use OSWP_Functions;

    public function __construct()
    {
    }

    public static function errorHTML(string $message)
    { 

        if( empty( $message ) )
        {
            parent::_die( 'Message Field Blank! (Required)' );
        }
        else
        { 
            echo '
            <style>
                .container{
                    background-color: rgb(105, 0, 0);
                }
                .container .body{
                    padding: 10px;
                    color:white;
                }
                .container .body .error-title{
                    text-align: center;
                }
                .container .body .error-title .exclamation{
                    font-size: 35px;
                    color: rgb(194, 0, 0);
                }
                .container .body .error-message{
                    text-align: center;
                    justify-content: center;
                    align-items: center; 
                    font-size: 20px;
                }
            </style>
            <div class="container">
                <div class="body">
                    <h1 class="error-title">
                        <span class="exclamation">( ! )</span> 
                        Error
                    </h1>
                    <p class="error-message">
                        '. $message .'
                    </p>
                </div>
            </div>
            ';
        }
    }

    public static function returnError(string $message)
    {
        if( empty( $message ) )
        {
            parent::_die( 'Message Field Blank! (Required)' );
        }
        else 
        {
            return self::errorHTML( $message );
        }
    }

    public static function createError()
    {
    }

}


?>