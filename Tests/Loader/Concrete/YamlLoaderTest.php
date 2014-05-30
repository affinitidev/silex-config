<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Tests\Loader\Concrete;

/**
 * The ConfigServiceProvider test case.  This is more of a completely
 * functional test.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class YamlLoaderTest extends \PHPUnit_Framework_TestCase
{
    use FileLoaderTestTrait;
    
    public function setUp() {
        $this->newYamlLoader();
        $this->setTestData([
            'supports' => [
                'valid'     => 'test.yml',
                'invalid'    => 'test.php'
            ],
            'load' => [
                'path'      => __DIR__ . '/../../Fixtures/Config',
                'file' => [
                    'valid'     => 'yaml_test.yml',
                    'invalid'   => 'invalid.yml'
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
                
        $locator = $this->getMockLocator('testfile.yml', 'http://someserver.com');
        $loader->setLocator($locator);
                
        try {
            $result = $loader->load('testfile.yml', null);
            $this->fail('Exception raised: ' . $ex->getMessage());
        } catch(\InvalidArgumentException $ex) {
            // Do nothing.
        }
    }
}