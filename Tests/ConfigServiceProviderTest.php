<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Tests;

use Silex\Application;
use Affiniti\Config\ConfigServiceProvider;
use Affiniti\Config\Tests\Fixtures\Definitions\TestDefinition;
use Affiniti\Config\Exception\ConfigNotFound;
use Affiniti\Config\Exception\PathsNotSpecified;

/**
 * The ConfigServiceProvider test case.  This is more of a completely
 * functional test.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigServiceProviderTest extends \PHPUnit_Framework_TestCase 
{
    public function testCustomConfigName()
    {
        $app = new Application();
        $app->register(new ConfigServiceProvider('Test.Config'));
        
        $this->assertTrue(isset($app['Test.Config.manager']));
        $this->assertTrue(isset($app['Test.Config.paths']));
        $this->assertTrue(isset($app['Test.Config.cache.path']));
        $this->assertTrue(isset($app['Test.Config.cache.type']));
        $this->assertTrue(isset($app['Test.Config']));
    }
    
    public function testDefaultOptions()
    {
        $app = new Application();
        $app->register(new ConfigServiceProvider());
        
        $this->assertTrue(array() === $app['config.paths']);
        $this->assertTrue(null === $app['config.cache.path']);
        $this->assertTrue('disabled' === $app['config.cache.type']);
    }
    
    public function testLoadWithoutPaths()
    {
        $app = new Application();
        $app->register(new ConfigServiceProvider());
        
        try{
            $config = $app['config'];
            $this->fail('Expected exception.');
        } catch (PathsNotSpecified $ex) {
            // Do nothing.
        }
    }
    
    public function testLoadYamlFile()
    {
        $app = new Application();
        $path = __DIR__ . '/Fixtures/Config';
        
        $app->register(new ConfigServiceProvider(), array(
            'config.paths' => [ $path ]
        ));
        
        $app['config.manager']->addFile('yaml_test.yml', 'test');
        
        $testArray = [
            'test' => [
                'value' => 1,
                'other' => 2
            ]
        ];
        
        try {
            $this->assertTrue($testArray == $app['config']['test']);
        } catch(ConfigNotFound $ex) {
            $this->fail('Exception raised: ' . $ex->getMessage());
        }
        
        // Test for value which doesn't exist.
        try {
            $value = $app['config']['value'];
            $this->fail('Expected exception.');
        } catch(ConfigNotFound $ex) {
            // Do nothing.
        }
    }
    
    public function testLoadYamlFileWithDefinition()
    {
        $app = new Application();
        $path = __DIR__ . '/Fixtures/Config';
        
        $app->register(new ConfigServiceProvider(), array(
            'config.paths' => [ $path ]
        ));
        
        $app['config.manager']->addFile('yaml_test.yml', 'test');
        $app['config.manager']->addDefinition(new TestDefinition());
        
        $testArray = [
            'test' => [
                'value' => 1,
                'other' => 2
            ]
        ];
        
        try {
            $this->assertTrue($testArray == $app['config']['test']);
        } catch(ConfigNotFound $ex) {
            $this->fail('Exception raised: ' . $ex->getMessage());
        }
        
        // Test for value which doesn't exist.
        try {
            $value = $app['config']['value'];
            $this->fail('Expected exception.');
        } catch(ConfigNotFound $ex) {
            // Do nothing.
        }
    }
    
    public function testLoadYamlFileCacheGet()
    {
        $app = new Application();
        $path = __DIR__ . '/Fixtures/Config';
        $cachePath = __DIR__ . '/Fixtures/Cache/get_cache_test.php';
        
        $app->register(new ConfigServiceProvider(), array(
            'config.paths' => [ $path ],
            'config.cache.enabled' => true,
            'config.cache.path' => $cachePath,
            'config.cache.type' => 'php'
        ));
                
        $app['config.manager']->addFile('yaml_test.yml', 'test');
        $app['config.manager']->addDefinition(new TestDefinition());

        // Tests that it loads the cache file (has an extra entry than the YAML file).
        $testArray = [
            'test' => [
                'value' => 1,
                'other' => 2,
                'cache' => true
            ]
        ];
        
        try {
            $this->assertTrue($testArray == $app['config']['test']);
        } catch(ConfigNotFound $ex) {
            $this->fail('Exception raised: ' . $ex->getMessage());
        }
    }
    
    public function testLoadYamlFileCacheWrite()
    {        
        $app = new Application();
        $path = __DIR__ . '/Fixtures/Config';
        $cachePath = __DIR__ . '/Fixtures/Cache/write_cache_test.php';
        
        if(true === file_exists($cachePath) && false === is_writable($cachePath))
        {
            $file = realpath($cachePath);
            echo "\n\nWarning: Cache write test cannot run - make sure file {$file} is writable.\n\n";
            return;
        }
        
        if(false === file_exists($cachePath) && false === is_writable(dirname($cachePath))) {            
            $file = dirname($cachePath);
            echo "\n\nWarning: Cache write test cannot run - make sure directory {$file} is writable.\n\n";
            return;
        }
        
        @unlink($cachePath);
        
        $app->register(new ConfigServiceProvider(), array(
            'config.paths' => [ $path ],
            'config.cache.enabled' => true,
            'config.cache.path' => $cachePath,
            'config.cache.type' => 'php'
        ));
                
        $app['config.manager']->addFile('yaml_test.yml', 'test');
        $app['config.manager']->addDefinition(new TestDefinition());

        // Tests that it writes the cache file.
        $testArray = [
            'test' => [
                'value' => 1,
                'other' => 2
            ]
        ];
        
        try {
            $this->assertTrue($testArray == $app['config']['test']);
            $includeArray = require $cachePath;            
            $this->assertTrue($testArray == $includeArray['test']);
        } catch(ConfigNotFound $ex) {
            $this->fail('Exception raised: ' . $ex->getMessage());
        }
    }
    
    public function testBoot()
    {
        $app = new Application();
        $provider = new ConfigServiceProvider();
        $provider->boot($app);
    }
}