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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\ConfigCache;
use Silex\ServiceProviderInterface;
use Affiniti\Config\ConfigManager;
use Affiniti\Config\Exception\ConfigException;
use Affiniti\Config\Loader\LoaderFactory;
use Affiniti\Config\Loader\Concrete\YamlLoader;
use Affiniti\Config\Loader\Concrete\PhpLoader;
use Affiniti\Config\Loader\Concrete\IniLoader;
use Affiniti\Config\Event\ConfigInitEvent;
use Affiniti\Config\Event\ConfigRegisteredEvent;
use Affiniti\Config\Event\ConfigLoadedEvent;
use Affiniti\Config\Event\Events;
use Affiniti\Config\Cache\CacheProducer;
use Affiniti\Config\Cache\CacheFactory;
use Affiniti\Config\Cache\Concrete\DisabledCache;
use Affiniti\Config\Cache\Concrete\PhpCache;

/**
 * Config Service Provider.  Exposes the Symfony Config component to the
 * Silex Microframework.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigServiceProvider implements ServiceProviderInterface
{
    protected $configName;
    
    /**
     * Constructor.  Allows the caller to specify the name of the config
     * service provider in case of naming conflicts.
     * 
     * @param string $configName
     */
    public function __construct($configName = 'config') 
    {
        $this->configName =  $configName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function register(\Silex\Application $app) 
    {           
        // Initialize options.
        $app[$this->configName . '.paths'] = [];
        $app[$this->configName . '.cache.path'] = null;
        $app[$this->configName . '.cache.type'] = 'disabled';
        
        $this->dispatchRegisteredEvent($app, $this->configName);
        
        $this->setupConfig($app, $this->configName);
        $this->setupEvents($app);
    }
    
    /**
     * {@inheritdoc}
     */
    public function boot(\Silex\Application $app) 
    {
        
    }
    
    /**
     * Set up the configuration manager and configuration definitions.
     */
    private function setupConfig(\Silex\Application $app, $configName)
    {        
        $app[$configName . '.manager'] = $app->share(
            function($app) {
                return new ConfigManager();
            }
        );
        
        $app[$configName] = $app->share(
            function($app) use($configName) {
                // Get the config paths and the file locator.
                $paths = $app[$configName . '.paths'];
                if(null === $paths || count($paths) === 0) {
                    throw ConfigException::pathsNotSpecified();
                }
                
                $locator = new FileLocator($paths);
                $this->dispatchInitEvent($app);
                
                // Get some app definitions.
                $cacheType  = $app[$this->configName . '.cache.type'];                
                $manager    = $app[$configName . '.manager'];
                  
                $loaderFactory = new LoaderFactory($locator, $manager->getLoaders());
                $cacheFactory = new CacheProducer($manager->getCacheFactories(), $app, $cacheType);
                $processor = new Processor();                
                
                $compiler = new ConfigCompiler(
                    $manager,
                    $loaderFactory,
                    $processor,
                    $cacheFactory
                );
                
                // Run the configuration compiler.
                $config = new Config($compiler->compile());
                $this->dispatchLoadedEvent($app, $config);
                return $config;
            }
        );
    }
    
    /**
     * Register the initialization event.
     */
    private function setupEvents(\Silex\Application $app)
    {
        $app['dispatcher']->addListener(Events::CONFIG_INIT,
            function(ConfigInitEvent $event)
            {            
                $manager = $event->getConfigManager();
                
                // Add the default loaders.
                $manager->addLoader(new YamlLoader());
                $manager->addLoader(new PhpLoader());
                $manager->addLoader(new IniLoader());
                
                // Create and add the default cache factories.
                $disabledCacheFactory = new CacheFactory('disabled', 
                        function(\Silex\Application $app) {
                            return new DisabledCache();
                        }
                    );
                
                $phpCacheFactory = new CacheFactory('php', 
                        function(\Silex\Application $app) {
                            $file = $app[$this->configName . '.cache.path'];
                            $fileCache = new ConfigCache($file, false);
                            return new PhpCache($fileCache, $file);
                        }
                    );
                
                $manager->addCacheFactory($disabledCacheFactory);
                $manager->addCacheFactory($phpCacheFactory);
            }
        );
    }
    
    private function dispatchRegisteredEvent(\Silex\Application $app, $configName)
    {
        $registeredEvent = new ConfigRegisteredEvent($configName);
        $app['dispatcher']->dispatch(Events::CONFIG_REGISTERED, $registeredEvent);
    }
    
    private function dispatchLoadedEvent(\Silex\Application $app, Config $config)
    {
        $loadedEvent = new ConfigLoadedEvent($config);
        $app['dispatcher']->dispatch(Events::CONFIG_LOADED, $loadedEvent);
    }
    
    private function dispatchInitEvent(\Silex\Application $app)
    {
        // Dispatch the config initialization event so that other providers
        // may register configurations.
        $initEvent = new ConfigInitEvent($app[$this->configName . '.manager']);
        $app['dispatcher']->dispatch(Events::CONFIG_INIT, $initEvent);
    }
}
