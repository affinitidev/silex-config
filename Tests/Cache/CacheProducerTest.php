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

namespace Affiniti\Config\Tests\Cache;

use Silex\Application;
use Affiniti\Config\Exception\ConfigException;
use Affiniti\Config\Cache\CacheProducer;
use Affiniti\Config\Cache\CacheInterface;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class CacheProducerTest extends \PHPUnit_Framework_TestCase
{
    private function getFactories($invalid = false)
    {
        $cache1 = $this->getMock('Affiniti\Config\Cache\CacheInterface');            
        $cache2 =  "not a cache";
        
        $factory1 = $this->getMockBuilder('Affiniti\Config\Cache\CacheFactory')->disableOriginalConstructor()->getMock();
        $factory2 = $this->getMockBuilder('Affiniti\Config\Cache\CacheFactory')->disableOriginalConstructor()->getMock();
        $factory3 = "not a factory";
        
        $factory1->expects($this->any())
                 ->method('getType')
                 ->will($this->returnValue('factory1'));
        
        $factory1->expects($this->any())
                 ->method('newInstance')
                 ->will($this->returnValue($cache1));
        
        $factory2->expects($this->any())
                 ->method('getType')
                 ->will($this->returnValue('factory2'));
        
        $factory2->expects($this->any())
                 ->method('newInstance')
                 ->will($this->returnValue($cache2));
        
        if(false === $invalid) {
            return [ $factory1, $factory2 ];
        } else {
            return [ $factory1, $factory2, $factory3 ];
        }
    }
    
    public function testProduce()
    {
        $factories = $this->getFactories();
        $app = $this->getMockBuilder('Silex\Application')->disableOriginalConstructor()->getMock();
        
        $factory = new CacheProducer($factories, $app, 'factory1');
        
        try {
            $cache = $factory->produce();
        } catch (ConfigException $ex) {
            $this->fail('Exception raised: ' . $ex->getMessage());
        }
        
        $this->assertTrue($cache instanceof CacheInterface);
    }
    
    public function testProduceNotFound()
    {
        $factories = $this->getFactories();
        $app = $this->getMockBuilder('Silex\Application')->disableOriginalConstructor()->getMock();
        
        $factory = new CacheProducer($factories, $app, 'factory3');
        
        try {
            $cache = $factory->produce();
            $this->fail('Expected exception.');
        } catch (ConfigException $ex) {
            // Do nothing.
        }
    }
    
    public function testProduceInvalidCache()
    {
        $factories = $this->getFactories(true);
        $app = $this->getMockBuilder('Silex\Application')->disableOriginalConstructor()->getMock();
        
        $factory = new CacheProducer($factories, $app, 'factory3');
        
        try {
            $cache = $factory->produce();
            $this->fail('Expected exception.');
        } catch (\InvalidArgumentException $ex) {
            // Do nothing.
        }
    }
    
    public function testNewInstanceInvalid()
    {
        $factories = $this->getFactories();
        $app = $this->getMockBuilder('Silex\Application')->disableOriginalConstructor()->getMock();
        
        $factory = new CacheProducer($factories, $app, 'factory2');
        
        try {
            $cache = $factory->produce();
            $this->fail('Expected exception.');
        } catch (\InvalidArgumentException $ex) {
            // Do nothing.
        }
    }
}
