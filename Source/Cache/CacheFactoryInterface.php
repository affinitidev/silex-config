<?php
/**
 * Affiniti Development
 * Config Service Provider
 *
 * @link        http://github.com/affinitidev/SilexConfig
 * @copyright   Brendan Bates (http://www.brendan-bates.com)
 * @license     http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 * @version     0.1
 */

namespace Affiniti\Config\Cache;

/**
 * Cache controller for the Config files.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
interface CacheFactoryInterface
{
    public function newInstance(\Silex\Application $app);
    
    public function getType();
}