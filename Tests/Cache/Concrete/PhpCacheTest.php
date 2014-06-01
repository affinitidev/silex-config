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

namespace Affiniti\Config\Tests\Cache\Concrete;

use Affiniti\Config\Cache\Concrete\PhpCache;
use Symfony\Component\Config\Resource\FileResource;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class PhpCacheTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $cachePath = __DIR__ . '/../../Fixtures/Cache/test_cache.php';
        $cache = $this->getMockBuilder('Symfony\Component\Config\ConfigCache')->disableOriginalConstructor()->getMock();       
        $phpCache = new PhpCache($cache, $cachePath);
        
        $testArray = require $cachePath;
        $returnArray = $phpCache->get();
        
        $this->assertTrue($testArray == $returnArray);
    }
    
    // WARNING
    // This test contains EVAL.
    public function testWrite()
    {
        $cachePath = __DIR__ . '/../../Fixtures/Cache/test_cache.php';        
        $dataArray = [ 'test' => 'write' ];        
        $cache = $this->getMockBuilder('Symfony\Component\Config\ConfigCache')->disableOriginalConstructor()->getMock();        
        $cache->expects($this->once())
              ->method('write')
              ->will($this->returnCallback(
                    function($data, $resource) use($dataArray) {
                        $data = str_replace('<?php', '', $data);
                        $testArray = eval($data);
                        $this->assertTrue($testArray == $dataArray);
                    }));
                        
        
        $phpCache = new PhpCache($cache, $cachePath);
        $phpCache->write($dataArray);
    }
    
    public function testExpired()
    {
        $cachePath = __DIR__ . '/../../Fixtures/Cache/test_cache.php';        
        $cache = $this->getMockBuilder('Symfony\Component\Config\ConfigCache')->disableOriginalConstructor()->getMock();
        $cache->expects($this->once())
              ->method('isFresh')
              ->will($this->returnValue(true));
        
        $phpCache = new PhpCache($cache, $cachePath);
        
        $this->assertFalse($phpCache->expired());
    }
}
