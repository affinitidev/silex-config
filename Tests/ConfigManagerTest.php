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

namespace Affiniti\Config\Tests;

use Affiniti\Config\ConfigManager;
use Affiniti\Config\ConfigFile;
use Affiniti\Config\Cache\CacheInterface;

/**
 * The ConfigManager test cases.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigManagerTest extends \PHPUnit_Framework_TestCase 
{
    public function testAddFile()
    {
        $manager = new ConfigManager();
        $exception = false;
        $file = new ConfigFile('testFile1.yml', 'definition');
        try {
            $manager->addFile($file);
        } catch(\InvalidArgumentException $e)
        {
            $this->fail('Exception raised: ' . $e->getMessage());
        }
        
        $file = $manager->getFiles()[0];
        $this->assertTrue($file->getFilename() === 'testFile1.yml' && $file->getType() === 'definition');
    }
    
    public function testAddDefinition()
    {
        $definition1 = $this->getMock('Affiniti\Config\Definition\DefinitionInterface');
        $definition2 = $this->getMock('Affiniti\Config\Definition\DefinitionInterface');
       
        $manager = new ConfigManager();
        $manager->addDefinition($definition1);
        $manager->addDefinition($definition2);
       
        foreach($manager->getDefinitions() as $definition) {
            $this->assertTrue($definition === $definition1 || $definition === $definition2);
        }
    }
    
    public function testAddLoader()
    {
        $loader1 = $this->getMock('Affiniti\Config\Loader\LoaderInterface');
        $loader2 = $this->getMock('Affiniti\Config\Loader\LoaderInterface');
        
        $manager = new ConfigManager();
        $manager->addLoader($loader1);
        $manager->addLoader($loader2);
       
        foreach($manager->getLoaders() as $loader) {
            $this->assertTrue($loader === $loader1 || $loader === $loader2);
        }
    }
    
    public function testAddCacheFactories()
    {
        $factory1 = $this->getMockBuilder('Affiniti\Config\Cache\CacheFactory')->disableOriginalConstructor()->getMock();
        $factory2 = $this->getMockBuilder('Affiniti\Config\Cache\CacheFactory')->disableOriginalConstructor()->getMock();               
                
        $manager = new ConfigManager();
        $manager->addCacheFactory($factory1);
        $manager->addCacheFactory($factory2);
       
        $app = $this->getMockBuilder('Silex\Application')->disableOriginalConstructor()->getMock();
            
        foreach($manager->getCacheFactories() as $factory) {
            
            $this->assertTrue($factory === $factory1 || $factory === $factory2);
        }
    }
}
