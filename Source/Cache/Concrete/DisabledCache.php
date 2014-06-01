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

namespace Affiniti\Config\Cache\Concrete;
use Affiniti\Config\Cache\CacheInterface;

/**
 * Default disabled cache implementation.  Always returns expired.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class DisabledCache implements CacheInterface
{
    public function expired() 
    {
        return true;
    }

    public function get() 
    {
        return null;
    }

    public function write(array $data) 
    {
        return;
    }

}