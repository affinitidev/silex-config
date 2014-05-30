<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Tests\Cache\Concrete;

use Affiniti\Config\Cache\Concrete\DisabledCache;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class DisabledCacheTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {     
        $disabledCache = new DisabledCache();        
        $returnArray = $disabledCache->get();        
        $this->assertTrue(null === $returnArray);
    }
    
    public function testWrite()
    {
        $disabledCache = new DisabledCache();
        $disabledCache->write([]);
    }
    
    public function testExpired()
    {
        $disabledCache = new DisabledCache();
        $this->assertTrue($disabledCache->expired());
    }
}
