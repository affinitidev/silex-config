<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Tests\Fixtures\Definitions;

use Affiniti\Config\Definition\Definition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class TestDefinition extends Definition
{
    public function getConfigTreeBuilder() {
        $tree = new TreeBuilder();
        $root = $tree->root('test');
        
        $root->children()
            ->arrayNode('test')
                ->children()
                    ->scalarNode('value')->end()
                    ->scalarNode('other')->end()
                ->end()
            ->end()
        ->end();
        
        return $tree;
    }
}
