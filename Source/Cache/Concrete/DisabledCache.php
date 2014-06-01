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
 * Default disabled cache implementation.  Always returns expired and writes
 * nothing.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class DisabledCache implements CacheInterface
{
    /**
     * {@inheritdoc}
     */
    public function expired() 
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function get() 
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $data) 
    {
        return;
    }

}