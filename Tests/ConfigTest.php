<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Tests;

use Affiniti\Config\Config;
use Affiniti\Config\Exception\ConfigNotFound;

/**
 * The ConfigManager test cases.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigTest extends \PHPUnit_Framework_TestCase 
{
    public function testConfig()
    {
        $testArray = [
            'test' => [
                'value' => 1,
                'other' => 2
            ]
        ];
        
        $config = new Config($testArray);
        
        // Check for value that exists.
        try {
            $this->assertTrue(1 === $testConfig = $config['test']['value']);
        } catch(ConfigNotFound $ex) {
            $this->fail('Exception raised.');
        }
        
        // Check for value that doesn't exist.
        try {
            $otherConfig = $config['other'];
            $this->fail('Expected exception.');
        } catch (ConfigNotFound $ex) {
            // Do nothing.
        }
        
        $config['testSet'] = true;
        $this->assertTrue($config['testSet']);
        
        unset($config['testSet']);
        $this->assertFalse(isset($config['testSet']));
    }
}