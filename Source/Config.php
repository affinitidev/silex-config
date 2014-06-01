<?php
/**
 * Affiniti Development
 * 
 * Config Service Provider
 *
 * @link        http://github.com/affinitidev/silex-config
 * @copyright   Brendan Bates (http://www.brendan-bates.com)
 * @license     http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */


namespace Affiniti\Config;

use Affiniti\Config\Exception\ConfigException;

/**
 * Wrapper for the configuration array.  Throws a ConfigException if an index
 * is not found.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class Config implements \ArrayAccess 
{
    private $config;
    
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    public function offsetExists($offset) 
    {
        if(isset($this->config[$offset])) {
            return true;
        } else {
            return false;
        }
    }

    public function offsetGet($offset) 
    {
        if(false === $this->offsetExists($offset)) {
            throw ConfigException::configNotFound($offset);
        } else {
            return $this->config[$offset];
        }
    }

    public function offsetSet($offset, $value) 
    {
        $this->config[$offset] = $value;
    }

    public function offsetUnset($offset) 
    {
        unset($this->config[$offset]);
    }
}
