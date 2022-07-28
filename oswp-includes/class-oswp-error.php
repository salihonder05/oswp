<?php 

namespace Error;

trait OSWP_Error{

    public function __construct()
    {
    }

    public function globalError()
    {
        /**
         * Usage function inside function
         * 
         * Örn:
         * $oswpdb->globalError()->returnError();
         */
        return $this;
    }

    public function errorHTML(string $message)
    { 

        if( empty( $message ) )
        {
            //parent::_die( 'Message Field Blank! (Required)' );
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

    public function returnError(string $message)
    {
        if( empty( $message ) )
        {
            //parent::_die( 'Message Field Blank! (Required)' );
        }
        else 
        {
            $this->errorHTML( $message );
            die( "KODLARINIZ ARTIK ÇALIŞMAYACAK !" );
        }
    }

    public function returnErrorDie( $message )
    {
        die( $message );
    }

    public static function createError()
    {
    }

}


?>