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