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

namespace Affiniti\Config\Cache\Concrete;

use Symfony\Component\Config\ConfigCache;
use Affiniti\Config\Cache\CacheInterface;

/**
 * Cache controller for the Config files.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class PhpCache implements CacheInterface
{
    private $fileCache;
    private $cachePath;
    
    public function __construct(ConfigCache $fileCache, $cachePath)
    {
        $this->fileCache = $fileCache;
        $this->cachePath = $cachePath;
    }
    
    public function expired() 
    {
        return (false === $this->fileCache->isFresh());
    }

    public function get() 
    {         
        return require $this->cachePath;
    }

    public function write(array $data) 
    {
        $content = '<?php return ' . var_export($data, true) . ';';
        $this->fileCache->write($content, []);
    }

}