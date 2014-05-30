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

namespace Affiniti\Config;

use Affiniti\Config\Definition\DefinitionInterface;
use Affiniti\Config\Loader\LoaderInterface;
use Affiniti\Config\Cache\CacheFactory;

/**
 * Config Service Provider.  Exposes the Symfony Config component to the
 * Silex Microframework.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigManager
{
    private $loaders = [];
    private $files = [];
    private $definitions = [];
    private $cacheFactories = [];
    
    /**
     * Adds a configuration file to be processed.
     * 
     * @param string $filename
     * @param string $type
     */
    public function addFile($filename, $type) 
    {
        if(null === $filename || null === $type) {
            throw new \InvalidArgumentException("Null filename is not allowed.");
        }
        
        $this->files[] = new ConfigFile($filename, $type);
    }
    
    /**
     * Adds a Configuration Definition.
     * 
     * @param \Affiniti\Config\DefinitionInterface $definition
     */
    public function addDefinition(DefinitionInterface $definition)
    {
        $this->definitions[] = $definition;
    }
    
    /**
     * Adds a Configuration file loader.
     * 
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function addLoader(LoaderInterface $loader)
    {
        $this->loaders[] = $loader;
    }
    
    /**
     * Adds a Cache factory.
     * 
     * @param type $type
     * @param \Closure $cacheFactory
     */
    public function addCacheFactory(CacheFactory $factory)
    {
        $this->cacheFactories[] = $factory;
    }
    
    /**
     * Returns an array of specified config files.
     * 
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }
    
    /**
     * Returns an array of specified config definitions.
     * 
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
    
    /**
     * Returns an array of specified config loaders.
     * 
     * @return type
     */
    public function getLoaders()
    {
        return $this->loaders;
    }
    
    /**
     * Returns an array of specified cache factories.
     * 
     * @return array
     */
    public function getCacheFactories()
    {
        return $this->cacheFactories;
    }
}
