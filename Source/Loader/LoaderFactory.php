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

use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Affiniti\Config\Loader\LoaderInterface;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class LoaderFactory 
{    
    private $fileLocator;
    private $loaders;
    
    /**
     * 
     * @param \Symfony\Component\Config\FileLocatorInterface $fileLocator
     *      The file locator.
     * 
     * @param array $loaders
     *      An array of valid \Affiniti\Config\Loader\LoaderInterface objects.
     */
    public function __construct(FileLocatorInterface $fileLocator, array $loaders)
    {
        $this->loaders = $loaders;
        $this->fileLocator = $fileLocator;
    }
    
    /**
     * Returns a new DelegatingLoader which allows multiple loaders to be managed.
     * 
     * @return \Symfony\Component\Config\Loader\DelegatingLoader
     *      The DelegatingLoader which contains all other defined loaders.
     * 
     * @throws \InvalidArgumentException
     */
    public function newInstance()
    {
        // Set the file locators in each loader instance.
        foreach($this->loaders as $loader) {
            if(false === $loader instanceof LoaderInterface) {
                throw new \InvalidArgumentException("Loaders must implement Affiniti\Config\Loader\LoaderInterface.");
            }
            
            $loader->setLocator($this->fileLocator);
        }
        
        return new DelegatingLoader(new LoaderResolver($this->loaders));
    }
}
