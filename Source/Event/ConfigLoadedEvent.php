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

namespace Affiniti\Config\Event;

use Symfony\Component\EventDispatcher\Event;
use Affiniti\Config\Config;

/**
 * This event is dispatched after the config has been loaded.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigLoadedEvent extends Event
{
    protected $config;
    
    public function __construct(Config $config)
    {
        $this->config = $config;
    }
    
    public function getConfig()
    {
        return $this->config;
    }
}
