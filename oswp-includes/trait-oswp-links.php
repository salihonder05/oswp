<?php

namespace Link;

trait OSWP_Links
{
    public function __construct()
    {
    }

    /**
     * Get Site Page URI
     * @param string $extraPath   Extra Link Way ( /way1/way2  esc.)
     * @return object
     */
    public function _getURL( string $extraPath )
    {
        if( empty( is_string( $extraPath ) ) )
        {
            return $this->_return( false , $extraPath , 'Parameter Not String or Empty' );
        }

        return $this->_return( true , $_SERVER[ 'REQUEST_URI' ] . $extraPath , 'True');
    }

    /**
     * Get Site Page Root URL
     * @param string $extraPath   Extra Link Way ( /way1/way2  esc.)
     * @return object
     */
    public function _getRootURL( string $extraPath )
    {
        if( empty( is_string( $extraPath ) ) )
        {
            return $this->_return( false , $extraPath , 'Parameter Not String or Empty' );
        }

        return $this->_return( true , $_SERVER[ 'DOCUMENT_ROOT' ] . $extraPath , 'True');
    }

    /**
     * Get Site Page Script Name
     * @param string $extraPath   Extra Link Way ( /way1/way2  esc.)
     * @return object
     */
    public function _getScriptName()
    {
        return $this->_return( true , $_SERVER[ 'SCRIPT_NAME' ] , 'True');
    }

    /**
     * Get Site URL
     * @param string $extraPath   Extra Link Way ( /way1/way2  esc.)
     * @return object
     */
    public function _siteURL( string $extraPath )
    {
        if( empty( is_string( $extraPath ) ) )
        {
            return $this->_return( false , $extraPath , 'Parameter Not String or Empty' );
        }

        return $this->_return( true , $_SERVER[ 'SERVER_NAME' ] . $extraPath , 'True' );
    }

    /**
     * Get Site Page Self URL
     * @param string $extraPath   Extra Link Way ( /way1/way2  esc.)
     * @return object
     */
    public function _getPHPSelf( string $extraPath )
    {
        if( is_string( $extraPath ) )
        {
            return $this->_return( true , $_SERVER['PHP_SELF'] . $extraPath , 'True - '.__FUNCTION__.'()' );
        }

        return $this->_return( false , $extraPath , 'Parameter Not String !' );
    }
}


?>