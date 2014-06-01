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

use Affiniti\Config\ConfigFile;
use Affiniti\Config\ConfigCompiler;
use Affiniti\Config\Exception\ConfigException;
use Affiniti\Config\Exception\ConfigAlreadyLoaded;

/**
 * The ConfigManager test cases.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigCompilerTest extends \PHPUnit_Framework_TestCase 
{    
    private function getMockLoaderFactory($fileCount, $returnVal = null)
    {        
        $factoryStub = $this->getMockBuilder('Affiniti\Config\Loader\LoaderFactory')->disableOriginalConstructor()->getMock();
        $loaderStub = $this->getMock('Symfony\Component\Config\Loader\LoaderInterface');
        
        if(null == $returnVal) {
            $loaderStub->expects($this->exactly($fileCount))
                       ->method('load')
                       ->will($this->returnValue(array()));
        } else {
            $loaderStub->expects($this->exactly($fileCount))
                       ->method('load')
                       ->will($this->returnValueMap($returnVal));
        }
        
        $factoryStub->expects($this->once())
             ->method('newInstance')
             ->will($this->returnValue($loaderStub));
        
        return $factoryStub;
    }
    
    private function getMockProcessor($definitionCount)
    {
        $processorStub = $this->getMock('Symfony\Component\Config\Definition\Processor');
        
        $processorStub->expects($this->exactly($definitionCount))
                      ->method('processConfiguration')
                      ->willReturnArgument(1);
        
        return $processorStub;
    }
    
    private function getMockCacheFactory()
    {        
        $cache = $this->getMockBuilder('Affiniti\Config\Cache\CacheInterface')->disableOriginalConstructor()->getMock();
        $cache->expects($this->once())
              ->method('expired')
              ->will($this->returnValue(true));
        
        $cacheFactory = $this->getMockBuilder('Affiniti\Config\Cache\CacheProducer')->disableOriginalConstructor()->getMock();
        $cacheFactory->expects($this->once())
                     ->method('produce')
                     ->will($this->returnValue($cache));
        
        return $cacheFactory;
    }
    
    /**
     * Test the compiler on 4 files with 2 definitions.
     */
    public function testCompile()
    {
        $manager = $this->getMock('Affiniti\Config\ConfigManager');
        
        $definition1 = $this->getMock('Affiniti\Config\Definition\DefinitionInterface');
        $definition1->expects($this->any())
                    ->method('getType')
                    ->willReturn('definition1');
        
        $definition2 = $this->getMock('Affiniti\Config\Definition\DefinitionInterface');
        $definition2->expects($this->any())
                    ->method('getType')
                    ->willReturn('definition2');
        
        $file1 = new ConfigFile('file1', 'definition1');
        $file2 = new ConfigFile('file2', 'definition1');
        $file3 = new ConfigFile('file3', 'definition2');
        $file4 = new ConfigFile('file4', 'no_definition');
        
        $manager->expects($this->any())
                ->method('getFiles')
                ->willReturn([ $file1, $file2, $file3, $file4 ]);
        
        $manager->expects($this->any())
                ->method('getDefinitions')
                ->willReturn([ $definition1, $definition2 ]);
        
        // Load 4 files - process 2 against definitions.
        $compiler = new ConfigCompiler($manager, $this->getMockLoaderFactory(4), $this->getMockProcessor(2), $this->getMockCacheFactory());
        
        try {
            $compiler->compile();
        } catch (ConfigException $ex) {
            $this->fail('Config exception caught: ' . $ex->getMessage());
        }
    }
    
    public function testCompileWithoutDefinitions()
    { 
        $manager = $this->getMock('Affiniti\Config\ConfigManager');
        
        $file1 = new ConfigFile('file1.yml', 'config');
        $file2 = new ConfigFile('file1.php', 'config');
        
        
        $manager->expects($this->any())
                ->method('getFiles')
                ->willReturn([ $file1, $file2 ]);
        
        $manager->expects($this->any())
                ->method('getDefinitions')
                ->willReturn([]);
        
        $config1 = array(
            'test' => [
                'value' => 1,
                'other' => 2
            ]
        );
        
        $config2 = array(
            'test' => [
                'value' => 2,
                'merge' => 3
            ],
            'merge' => true
        );
        
        $result = array(
            'config' => [
                'test' => [
                    'value' => [
                        1, 2
                    ],
                    'other' => 2,
                    'merge' => 3
                ],
                'merge' => true
            ]
        );
        
        $returnMap = array(
            [ 'file1.yml', null, $config1 ],
            [ 'file1.php', null, $config2 ]
        );
        
        $mockLoader = $this->getMockLoaderFactory(2, $returnMap);
        
        // Load 2 files - process 0 against definitions.
        $compiler = new ConfigCompiler($manager, $mockLoader, $this->getMockProcessor(0), $this->getMockCacheFactory());
        
        try {
            $config = $compiler->compile();
            $this->assertTrue($result == $config);
        } catch (ConfigException $ex)
        { 
            $this->fail('Exception raised: ' . $ex->getMessage());
        }
    }
}