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
use Affiniti\Config\ConfigManager;

/**
 * Event representing the initialization of the config service provider.  This
 * event is dispatched before any configurations are loaded.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigInitEvent extends Event
{
    protected $configManager;
    
    public function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }
    
    public function getConfigManager()
    {
        return $this->configManager;
    }
}
