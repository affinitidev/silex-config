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

namespace Affiniti\Config\Tests\Loader\Concrete;

use Affiniti\Config\Loader\LoaderInterface;

/**
 * The ConfigServiceProvider test case.  This is more of a completely
 * functional test.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
trait FileLoaderTestTrait
{
    protected $loader;
    protected $data;
    
    protected function newPhpLoader()
    {
        $this->setLoader(new \Affiniti\Config\Loader\Concrete\PhpLoader());
    }
    
    protected function newYamlLoader()
    {
        $this->setLoader(new \Affiniti\Config\Loader\Concrete\YamlLoader());
    }
    
    protected function newIniLoader()
    {
        $this->setLoader(new \Affiniti\Config\Loader\Concrete\IniLoader());
    }
    
    public function setLoader(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }
    
    public function setTestData(array $data)
    {
        $this->data = $data;
    }
    
    public function getLoader()
    {
        return $this->loader;
    }
    
    public function testSupports()
    {
        $valid   = $this->data['supports']['valid'];
        $invalid = $this->data['supports']['invalid'];       
        
        $loader = $this->getLoader();
        
        $this->assertTrue($loader->supports($valid));
        $this->assertFalse($loader->supports($invalid));
    }
    
    public function testLoad()
    {
        $file       = $this->data['load']['file']['valid'];
        $path       = $this->data['load']['path'];
        $expected   = $this->data['expected'];
        
        $loader = $this->getLoader();
                
        $locator = $this->getMockLocator($file, $path);
        $loader->setLocator($locator);
                
        try {
            $result = $loader->load($file);
            $this->assertTrue($result == $expected);
        } catch(\InvalidArgumentException $ex) {
            $this->fail('Exception raised: ' . $ex->getMessage());
        }
    }
    
    public function testLoadInvalidFile()
    {
        $file = $this->data['load']['file']['invalid'];
        $path = $this->data['load']['path'];
        
        $loader = $this->getLoader();
        
        $locator = $this->getMockLocator($file, $path);
        $loader->setLocator($locator);
        
        try {            
            $result = $loader->load($file);
            $this->fail('Exception expected.');
        } catch (\InvalidArgumentException $ex) {
            // Do nothing.
        }
    }
    
    private function getMockLocator($file, $path)
    {
        $locator = $this->getMock('Symfony\Component\Config\FileLocatorInterface');
        $locator->expects($this->once())
                ->method('locate')
                ->with($this->equalTo($file))
                ->will($this->returnValue($path . '/' . $file));
        
        return $locator;        
    }
}