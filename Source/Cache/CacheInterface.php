<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Cache;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
interface CacheInterface 
{
    /**
     * Determines whether or not the cache is expired.
     * 
     * @return boolean
     */
    public function expired();
    
    /**
     * Writes an array of data to a PHP file.
     * 
     * @return void
     */
    public function write(array $data);
    
    /**
     * Gets the array from the cache file.
     * 
     * @return array
     */
    public function get();
}
