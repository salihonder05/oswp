<?php
/**
 * Traitlerde require sırası önemli
 * function trait'ini error traitine attım . böylece db sınıfında kullandım.
 * require 'class-oswp-error.php'; kodu en aşağıda olursa hata alırsın . Trait not found diye.
 */ 


/**
 * Traits
 */

require 'class-oswp-error.php';
require 'oswp-functions.php';


/**
 * Classes
 */

require 'class-oswp-db.php';

/**
 * use Classes
 */

use Class_DB\OSWP_DB;

/**
 * new Class Names
 */
$oswpdb = new OSWP_DB();

?>