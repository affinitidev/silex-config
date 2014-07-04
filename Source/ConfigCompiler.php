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

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Affiniti\Config\Loader\LoaderFactory;
use Affiniti\Config\Exception\ConfigException;
use Affiniti\Config\Cache\CacheProducer;

/**
 * Config Service Provider.  Exposes the Symfony Config component to the
 * Silex Microframework.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigCompiler
{
    private $processor;
    private $loaderFactory;
    private $configManager;
    private $cacheFactory;
    
    /**
     * Constructor.
     * 
     * @param \Affiniti\Config\ConfigManager $configManager
     *      The ConfigManager object.
     * 
     * @param \Affiniti\Config\Loader\LoaderFactory $loaderFactory
     *      Loader factory to produce the delegating loader.
     * 
     * @param \Symfony\Component\Config\Definition\Processor $processor
     *      Symfony configuration processor.
     * 
     * @param \Affiniti\Config\Cache\CacheProducer $cacheFactory
     *      Cache producer.
     * 
     */
    public function __construct(
            ConfigManager $configManager,
            LoaderFactory $loaderFactory,
            Processor $processor,
            CacheProducer $cacheFactory)
    {        
        $this->configManager = $configManager;
        $this->loaderFactory = $loaderFactory;
        $this->processor = $processor;
        $this->cacheFactory  = $cacheFactory;
    }
    
    /**
     * Builds the configuration tree out of all of the App configuration definitions.
     * 
     * @return array Array of configuration values.
     */
    public function compile()
    {
        $loader = $this->loaderFactory->newInstance();        
        $cache = $this->cacheFactory->produce();
        
        if(true === $cache->expired()) {
            $config = $this->loadConfig($loader);
            $cache->write($config);
        } else {
            $config = $cache->get();
        }
        
        return $config;
    }
    
    private function loadConfig(LoaderInterface $loader)
    {
        $files = $this->configManager->getFiles();
        $config = [];
        
        // Load configs for all definitions.
        foreach($this->configManager->getDefinitions() as $definition)
        {            
            $type = $definition->getType();
            $rawConfig = $this->loadFilesByType($loader, $files, $type);
            $config[$type] = [];
            
            if(false === empty($rawConfig)) {
                try {
                    $config[$type] = $this->processor->processConfiguration($definition, $rawConfig);
                } catch(InvalidConfigurationException $ex) {
                    throw ConfigException::validationError($ex->getMessage());
                }
            }            
        }
        
        // Check for configs without definitions.
        foreach($this->configManager->getFiles() as $file)
        {
            if(false === $file->isLoaded()) {            
                $name = $file->getType();
                
                // Merge the array if it exists already.
                if(true === isset($config[$name])) {
                    $config[$name] = array_merge_recursive($config[$name], $this->loadFile($loader, $file));
                } else {
                    $config[$name] = $this->loadFile($loader, $file);
                }
            }
        }
        
        return $config;
    }
    
    private function loadFilesByType(LoaderInterface $loader, $files, $type)
    {
        $rawConfig = [];
        
        foreach($files as $file) {
            if($file->getType() == $type && false === $file->isLoaded()) {
                $rawConfig[] = $this->loadFile($loader, $file);
            }
        }
        
        return $rawConfig;
    }
    
    private function loadFile(LoaderInterface $loader, ConfigFile $file)
    {        
        $content = $loader->load($file->getFilename());
        $file->setLoaded();
        
        return $content;
    }
}
