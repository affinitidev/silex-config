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

namespace Affiniti\Config\Tests\Event;

use Affiniti\Config\Event\ConfigInitEvent;

/**
 * The ConfigManager test cases.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigInitEventTest extends \PHPUnit_Framework_TestCase 
{    
    public function testGetConfigManager()
    {
        $manager = $this->getMock('Affiniti\Config\ConfigManager');        
        $event = new ConfigInitEvent($manager);        
        $this->assertTrue($manager === $event->getConfigManager());
    }
}