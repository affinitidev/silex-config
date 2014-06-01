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

use Symfony\Component\Yaml\Yaml;
use Affiniti\Config\Loader\Loader;

/**
 * YAML File Loader.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class YamlLoader extends Loader
{    
    /**
     * Loads and parses the given Yaml file into a PHP array.
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
        
        $this->loaded[$resource] = $path;

        return Yaml::parse(file_get_contents($path));
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
        return is_string($resource) && 'yml' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }

}
