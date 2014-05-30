<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Exception;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
abstract class ConfigException extends \Exception 
{        
    public static function configNotFound($name)
    {
        return new ConfigNotFound("The configuration '{$name}' was not found in the configuration container.");
    }
    
    public static function configNotArray($filename)
    {
        return new ConfigNotArray("The given configuration returned from PHP file '{$filename}' is not an array.");
    }
    
    public static function cacheFactoryNotFound($type)
    {
        return new CacheFactoryNotFound("The cache factory of type '{$type}' was not found.");
    }
    
    public static function pathsNotSpecified()
    {
        return new PathsNotSpecified("No configuration paths have been specified - cannot read configurations.");
    }
}
