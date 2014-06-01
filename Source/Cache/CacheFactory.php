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

namespace Affiniti\Config\Cache;

use Silex\Application;
use Affiniti\Config\Exception\ConfigException;

/**
 * Cache controller for the Config files.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class CacheFactory implements CacheFactoryInterface
{
    private $type;
    private $closure;
    
    public function __construct($type, \Closure $closure)
    {
        $this->type = $type;
        $this->closure = $closure;
    }
    
    public function newInstance(\Silex\Application $app)
    {
        $factory = $this->closure;
        $cache = $factory($app);
        return $cache;
    }
    
    public function getType()
    {
        return $this->type;
    }
}