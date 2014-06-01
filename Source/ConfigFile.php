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

namespace Affiniti\Config;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigFile 
{
    protected $filename;
    protected $type;
    protected $isLoaded = false;
    protected $content;
    
    public function __construct($filename, $type)
    {
        $this->filename = $filename;
        $this->type = $type;
    }
    
    public function getFilename()
    {
        return $this->filename;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setLoaded()
    {
        $this->isLoaded = true;
    }
    
    public function isLoaded()
    {
        return (true === $this->isLoaded);
    }
}
