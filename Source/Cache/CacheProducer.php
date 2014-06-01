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
 * This class is responsible for executing a cache factory and retrieving a
 * CacheInterface object.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class CacheProducer
{
    private $cacheFactories = [];
    private $app;
    private $type;
    
    /**
     * 
     * @param array $cacheFactories
     * @param \Silex\Application $app
     * @param string $type
     */
    public function __construct(array $cacheFactories, Application $app, $type)
    {
        $this->cacheFactories = $cacheFactories;
        $this->app = $app;
        $this->type = $type;
    }
    
    /**
     * Produces a CacheInterface object.
     * 
     * @return \Affiniti\Config\Cache\CacheInterface
     * 
     * @throws \InvalidArgumentException
     * @throws \Affiniti\Config\Exception\CacheFactoryNotFound
     */
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