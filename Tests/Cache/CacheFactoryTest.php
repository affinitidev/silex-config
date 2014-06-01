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

use Affiniti\Config\Cache\CacheFactory;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class CacheFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testNewInstance()
    {
        $returnObject = $this->getMock('Affiniti\Config\Cache\CacheInterface');
        $app = $this->getMockBuilder('Silex\Application')->disableOriginalConstructor()->getMock();
        
        $closure = function(\Silex\Application $app) use ($returnObject) {
            return $returnObject;
        };
        
        $cacheFactory = new CacheFactory('test', $closure);
        
        $this->assertTrue('test' === $cacheFactory->getType());
        $this->assertTrue($returnObject === $cacheFactory->newInstance($app));
    }
}
