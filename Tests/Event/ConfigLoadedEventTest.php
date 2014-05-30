<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Tests\Event;

use Affiniti\Config\Event\ConfigLoadedEvent;

/**
 * The ConfigManager test cases.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigLoadedEventTest extends \PHPUnit_Framework_TestCase 
{    
    public function testGetConfig()
    {
        $config = $this->getMock('Affiniti\Config\Config', null, [], '', false);
        $event = new ConfigLoadedEvent($config);        
        $this->assertTrue($config === $event->getConfig());
    }
}