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

namespace Affiniti\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Affiniti\Config\Loader\LoaderInterface;
use Symfony\Component\Config\FileLocatorInterface;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
abstract class Loader extends FileLoader implements LoaderInterface
{
    public function __construct() 
    {
        
    }
    
    public function setLocator(\Symfony\Component\Config\FileLocatorInterface $locator)
    {
        $this->locator = $locator;
    }
}
