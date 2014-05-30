<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Tests\Loader\Concrete;

use Affiniti\Config\Exception\ConfigNotArray;

/**
 * The ConfigServiceProvider test case.  This is more of a completely
 * functional test.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class PhpLoaderTest extends \PHPUnit_Framework_TestCase
{
    use FileLoaderTestTrait;
    
    public function setUp()
    {
        $this->newPhpLoader();
        $this->setTestData([
            'supports' => [
                'valid'     => 'test.php',
                'invalid'    => 'test.yml'
            ],
            'load' => [
                'path'      => __DIR__ . '/../../Fixtures/Config',
                'file' => [
                    'valid'     => 'php_test.php',
                    'invalid'   => 'invalid.php'
                ]
            ],
            'expected' => [                
                'test' => [
                    'value' => 1,
                    'other' => 2
                ]
            ]
        ]);
    }
    
    public function testNonLocalStream()
    {
        $loader = $this->getLoader();
                
        $locator = $this->getMockLocator('testfile.php', 'http://someserver.com');
        $loader->setLocator($locator);
                
        try {
            $result = $loader->load('testfile.php', null);
            $this->fail('Exception raised: ' . $ex->getMessage());
        } catch(\InvalidArgumentException $ex) {
            // Do nothing.
        }
    }
    
    public function testArrayNotReturned()
    {
        $loader = $this->getLoader();
                
        $locator = $this->getMockLocator('not_array.php', $this->data['load']['path']);
        $loader->setLocator($locator);
                
        try {
            $result = $loader->load('not_array.php', null);
            $this->fail('Exception raised: ' . $ex->getMessage());
        } catch(ConfigNotArray $ex) {
            // Do nothing.
        }
    }
}