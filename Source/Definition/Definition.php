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

use Affiniti\Config\Definition\DefinitionInterface;

/**
 * Abstract definition implementation.  Allows the 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
abstract class Definition implements DefinitionInterface
{    
    /**
     * {@inheritdoc}
     */
    public function getType() 
    {
        return lcfirst(str_replace('Definition', '', basename(get_class($this))));
    }
}
