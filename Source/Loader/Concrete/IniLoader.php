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

namespace Affiniti\Config\Loader\Concrete;

use Affiniti\Config\Loader\Loader;

/**
 * INI File Loader.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class IniLoader extends Loader
{    
    /**
     * Loads the given PHP file.
     * 
     * @param string $resource
     * @param string $type
     */
    public function load($resource, $type = null) 
    {
        $path = $this->locator->locate($resource);
        
        if (!stream_is_local($path)) {
            throw new \InvalidArgumentException(sprintf('This is not a local file "%s".', $path));
        }

        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('File "%s" not found.', $path));
        }

        $result = parse_ini_file($path, true);
        
        if (false === $result || array() === $result) {
            throw new \InvalidArgumentException(sprintf('The "%s" file is not valid.', $path));
        }
        
        return $result;
    }

    /**
     * Determines whether or not this FileLoader supports the given
     * resource.
     * 
     * @param type $resource
     * @param type $type
     * 
     * @return boolean
     */
    public function supports($resource, $type = null) 
    {
        return is_string($resource) && 'ini' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }

}
