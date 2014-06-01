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

/**
 * Class with events defined for the config service provider.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
final class Events 
{    
    const CONFIG_INIT = 'Affiniti\Config\Event\ConfigInit';
    const CONFIG_LOADED = 'Affiniti\Config\Event\ConfigLoaded';
    const CONFIG_REGISTERED = 'Affiniti\Config\Event\ConfigRegistered';
}
