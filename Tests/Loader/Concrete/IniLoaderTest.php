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

namespace Affiniti\Config\Tests\Loader\Concrete;

/**
 * The ConfigServiceProvider test case.  This is more of a completely
 * functional test.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class IniLoaderTest extends \PHPUnit_Framework_TestCase
{
    use FileLoaderTestTrait;
    
    public function setUp() {
        $this->newIniLoader();
        $this->setTestData([
            'supports' => [
                'valid'     => 'test.ini',
                'invalid'    => 'test.yml'
            ],
            'load' => [
                'path'      => __DIR__ . '/../../Fixtures/Config',
                'file' => [
                    'valid'     => 'ini_test.ini',
                    'invalid'   => 'invalid.ini'
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
                
        $locator = $this->getMockLocator('testfile.ini', 'http://someserver.com');
        $loader->setLocator($locator);
                
        try {
            $result = $loader->load('testfile.ini', null);
            $this->fail('Exception raised: ' . $ex->getMessage());
        } catch(\InvalidArgumentException $ex) {
            // Do nothing.
        }
    }
    
    public function testInvalidFormat()
    {
        $loader = $this->getLoader();
                
        $locator = $this->getMockLocator('invalid_format.ini', $this->data['load']['path']);
        $loader->setLocator($locator);
                
        try {
            $result = $loader->load('invalid_format.ini', null);
            $this->fail('Exception raised: ' . $ex->getMessage());
        } catch(\InvalidArgumentException $ex) {
            // Do nothing.
        }
    }
}