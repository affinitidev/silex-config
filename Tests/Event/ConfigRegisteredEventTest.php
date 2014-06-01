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

use Affiniti\Config\Event\ConfigRegisteredEvent;

/**
 * The ConfigManager test cases.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigRegisteredEventTest extends \PHPUnit_Framework_TestCase 
{    
    public function testGetConfigManager()
    {  
        $configName = 'test.config';
        $event = new ConfigRegisteredEvent($configName);
        $this->assertTrue($configName === $event->getConfigName());
    }
}