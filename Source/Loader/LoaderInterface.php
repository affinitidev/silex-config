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

use Symfony\Component\Config\Loader\LoaderInterface as BaseLoaderInterface;
use Symfony\Component\Config\FileLocatorInterface;

/**
 * YAML File Loader.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
interface LoaderInterface extends BaseLoaderInterface
{
    public function setLocator(FileLocatorInterface $locator);
}