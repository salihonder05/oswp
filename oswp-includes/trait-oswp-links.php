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

        return $_SERVER[ 'REQUEST_URI' ] . $extraPath;
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

        return $_SERVER[ 'DOCUMENT_ROOT' ] . $extraPath;
    }

    /**
     * Get Site Page Script Name
     * @param string $extraPath   Extra Link Way ( /way1/way2  esc.)
     * @return object
     */
    public function _getScriptName()
    {
        return $_SERVER[ 'SCRIPT_NAME' ];
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

        return $_SERVER[ 'SERVER_NAME' ] . $extraPath;
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
            return $_SERVER['PHP_SELF'] . $extraPath;
        }

        return $this->_return( false , $extraPath , 'Parameter Not String !' );
    }
}


?>