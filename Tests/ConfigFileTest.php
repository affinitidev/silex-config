<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Tests;

use Affiniti\Config\ConfigFile;

/**
 * The ConfigManager test cases.
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigFileTest extends \PHPUnit_Framework_TestCase 
{
    public function testConfigFile()
    {
        $file = new ConfigFile('TestFile.yml', 'definition');
        
        $this->assertTrue($file->getFilename() === 'TestFile.yml');
        $this->assertTrue($file->getType() === 'definition');
        $this->assertFalse($file->isLoaded());
    }
    
    public function testSetLoaded()
    {
        $file = new ConfigFile('TestFile.yml', 'definition');
        
        $this->assertFalse($file->isLoaded());
        $file->setLoaded();        
        $this->assertTrue($file->isLoaded());
    }
}