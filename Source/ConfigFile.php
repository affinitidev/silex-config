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
    
    /**
     * 
     * @param string $filename
     *      The name of the file, including extension.
     * 
     * @param string $type
     *      The 'type' of the configuration to load.
     */
    public function __construct($filename, $type)
    {
        $this->filename = $filename;
        $this->type = $type;
    }
    
    /**
     * Returns the filename, including extension.
     * 
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }
    
    /**
     * Returns the configuration type.
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Sets the state of the file to loaded.
     * 
     * @return void
     */
    public function setLoaded()
    {
        $this->isLoaded = true;
    }
    
    /**
     * Determines whether or not the file has been loaded.
     * 
     * @return boolean
     */
    public function isLoaded()
    {
        return (true === $this->isLoaded);
    }
}
