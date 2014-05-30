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

namespace Affiniti\Config\Definition;

use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Interface for a configuration definition.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
interface DefinitionInterface extends ConfigurationInterface
{
    /**
     * Returns the type of the definition.  This type is used to match a
     * configuration file to a specific config definition.
     * 
     * @return string
     */
    public function getType();
}
