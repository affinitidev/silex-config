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
		$reflect = new \ReflectionClass($this);
        return lcfirst(str_replace('Definition', '', $reflect->getShortName()));
    }
}
