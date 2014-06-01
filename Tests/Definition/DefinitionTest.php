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

namespace Affiniti\Config\Tests\Definition;

use Affiniti\Config\Tests\Fixtures\Definitions\TestDefinition;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class DefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testAbstractDefinition()
    {
        $definition = new TestDefinition;
        $this->assertTrue($definition->getType() === 'test');
    }
}
