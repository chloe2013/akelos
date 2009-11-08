<?php

// +----------------------------------------------------------------------+
// | Akelos Framework - http://www.akelos.org                             |
// +----------------------------------------------------------------------+
// | Released under the GNU Lesser General Public License, see LICENSE.txt|
// +----------------------------------------------------------------------+

require_once(AK_LIB_DIR.DS.'AkInflector.php');

/**
 * @package ActionWebservice
 * @subpackage Client
 * @author Bermi Ferrer <bermi a.t bermilabs c.om>
 * @license GNU Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 */

class AkActionWebServiceClient extends AkObject
{
    var $_available_drivers = array('xml_rpc');
    var $_Client;

    function __construct($client_driver)
    {
        $client_driver = AkInflector::underscore($client_driver);
        if(in_array($client_driver, $this->_available_drivers)){
            $client_class_name = 'Ak'.AkInflector::camelize($client_driver).'Client';
            require_once(AK_LIB_DIR.DS.'AkActionWebService'.DS.'Clients'.DS.$client_class_name.'.php');
            $this->_Client =& new $client_class_name($this);

        }else {
            trigger_error(Ak::t('Invalid Web Service driver provided. Available Drivers are: %drivers', array('%drivers'=>join(', ',$this->_available_drivers))), E_USER_WARNING);
        }
    }

    function init()
    {
        if(method_exists($this->_Client, 'init')){
            $args = func_get_args();
            call_user_func_array(array($this->_Client, 'init'), $args);
        }
    }
    
    function hasErrors()
    {
        return $this->_Client->hasErrors();
    }

    function getErrors()
    {
        return $this->_Client->getErrors();
    }

    
}

?>