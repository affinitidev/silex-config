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
    /**
     * Returns a new instance of a CacheInterface object.
     * 
     * @param \Silex\Application $app
     *      The Silex application.
     * 
     * @return \Affiniti\Config\Cache\CacheInterface
     */
    public function newInstance(\Silex\Application $app);
    
    /**
     * Returns the cache type.
     * 
     * @return string
     *      The cache type.
     */
    public function getType();
}