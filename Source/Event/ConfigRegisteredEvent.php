<?php

/**
 * Relax - The RESTful PHP Framework
 *
 * @link http://bitbucket.org/brendanbates89/relax
 * @copyright Brendan Bates (http://www.brendan-bates.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Affiniti\Config\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * 
 * 
 * @author Brendan Bates <me@brendan-bates.com>
 */
class ConfigRegisteredEvent extends Event
{
    protected $configName;
    
    public function __construct($configName)
    {
        $this->configName = $configName;
    }
    
    public function getConfigName()
    {
        return $this->configName;
    }
}
