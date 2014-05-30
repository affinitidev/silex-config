<?php
/**
 * Affiniti Development
 * Config Service Provider
 *
 * @link        http://github.com/affinitidev/SilexConfig
 * @copyright   Brendan Bates (http://www.brendan-bates.com)
 * @license     http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 * @version     0.1
 */

namespace Affiniti\Config\Cache;

use Silex\Application;
use Affiniti\Config\Exception\ConfigException;

/**
 * Cache controller for the Config files.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class CacheProducer
{
    private $cacheFactories = [];
    private $app;
    private $type;
    
    public function __construct(array $cacheFactories, Application $app, $type)
    {
        $this->cacheFactories = $cacheFactories;
        $this->app = $app;
        $this->type = $type;
    }
    
    public function produce()
    {
        $cacheFactory = null;
        foreach($this->cacheFactories as $factory)
        {
            if(false === $factory instanceof CacheFactoryInterface) {
                throw new \InvalidArgumentException("Array of Cache Factories must contain valid CacheFactory objects.");
            }
            
            if($this->type == $factory->getType()) {
                $cacheFactory = $factory;
                break;
            }
        }
        
        if(null === $cacheFactory)
        {
            throw ConfigException::cacheFactoryNotFound($this->type);
        }
            
        $cache = $cacheFactory->newInstance($this->app);
        
        if(false === $cache instanceof CacheInterface) {
            throw new \InvalidArgumentException("Cache factory must produce a valid CacheInterface object.");
        }
        
        return $cache;
    }
}