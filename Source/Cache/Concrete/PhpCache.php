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

use Symfony\Component\Config\ConfigCache;
use Affiniti\Config\Cache\CacheInterface;

/**
 * Implements a cache using an included PHP file.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class PhpCache implements CacheInterface
{
    private $fileCache;
    private $cachePath;
    
    /**
     * Constructor.
     * 
     * @param \Symfony\Component\Config\ConfigCache $fileCache
     * @param string $cachePath
     */
    public function __construct(ConfigCache $fileCache, $cachePath)
    {
        $this->fileCache = $fileCache;
        $this->cachePath = $cachePath;
    }
    
    /**
     * {@inheritdoc}
     */
    public function expired() 
    {
        return (false === $this->fileCache->isFresh());
    }

    /**
     * {@inheritdoc}
     */
    public function get() 
    {         
        return require $this->cachePath;
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $data) 
    {
        $content = '<?php return ' . var_export($data, true) . ';';
        $this->fileCache->write($content, []);
    }

}