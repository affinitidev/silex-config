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

namespace Affiniti\Config\Tests\Loader;

use Affiniti\Config\Loader\LoaderFactory;

/**
 * The ConfigServiceProvider test case.  This is more of a completely
 * functional test.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class LoaderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testNewInstance()
    {
        $locator = $this->getMock('Symfony\Component\Config\FileLocatorInterface');
        
        $loader1 = $this->getMock('Affiniti\Config\Loader\LoaderInterface');
        $loader1->expects($this->once())
                ->method('setLocator');
        
        $loader2 = $this->getMock('Affiniti\Config\Loader\LoaderInterface');
        $loader2->expects($this->once())
                ->method('setLocator');
        
        $loaderFactory = new LoaderFactory($locator, array($loader1, $loader2));
        
        try {
            $loader = $loaderFactory->newInstance();
        } catch (\InvalidArgumentException $ex) {
            $this->fail('Exception raised: ' . $ex->getMessage());
        }
    }
    
    public function testNewInstanceInvalid()
    {
        $locator = $this->getMock('Symfony\Component\Config\FileLocatorInterface');
        
        $loader1 = $this->getMock('Affiniti\Config\Loader\LoaderInterface');
        $loader1->expects($this->once())
                ->method('setLocator');
        
        $loader2 = $this->getMock('Affiniti\Config\Loader\LoaderInterface');
        $loader2->expects($this->once())
                ->method('setLocator');
        
        $loader3 = "this is not a LoaderInterface.";
        
        $loaderFactory = new LoaderFactory($locator, array($loader1, $loader2, $loader3));
        
        try {
            $loader = $loaderFactory->newInstance();
            $this->fail('Expected an exception to be raised.');
        } catch(\InvalidArgumentException $ex) {
            // Do nothing.
        }
    }
}