<?php
/*  
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * Copyright (c) 2009-2012 (original work) Public Research Centre Henri Tudor (under the project TAO-SUSTAIN & TAO-DEV);
 *               
 * 
 */

namespace oat\generisHard\models\proxy;

/**
 * @abstract
 * @access public
 * @author Jerome Bogaerts, <jerome.bogaerts@tudor.lu>
 * @package generisHard
 
 */
abstract class PersistenceProxy
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute impls
     *
     * @access protected
     * @var array
     */
    protected $impls = array();

    /**
     * Short description of attribute current
     *
     * @access private
     * @var string
     */
    private static $current = '';

    /**
     * Short description of attribute implementationHistory
     *
     * @access private
     * @var array
     */
    private static $implementationHistory = array();

    // --- OPERATIONS ---

    /**
     * Short description of method getImpToDelegateTo
     *
     * @abstract
     * @access public
     * @author Jerome Bogaerts, <jerome.bogaerts@tudor.lu>
     * @param  Resource resource
     * @param  array params
     * @return \core_kernel_persistence_ResourceInterface
     */
    public abstract function getImpToDelegateTo( \core_kernel_classes_Resource $resource, $params = array());

    /**
     * Short description of method singleton
     *
     * @access public
     * @author Jerome Bogaerts, <jerome.bogaerts@tudor.lu>
     * @return PersistenceProxy
     */
    public static function singleton()
    {
        $returnValue = null;

        // section 127-0-1-1--30506d9:12f6daaa255:-8000:000000000000130B begin
        throw new \Exception('Must be implemented by subclasses.');
        // section 127-0-1-1--30506d9:12f6daaa255:-8000:000000000000130B end

        return $returnValue;
    }

    /**
     * Short description of method getAvailableImpl
     *
     * @access protected
     * @author Jerome Bogaerts, <jerome.bogaerts@tudor.lu>
     * @param  array params
     * @return array
     */
    protected function getAvailableImpl($params = array())
    {
        $returnValue = array();

        // section 127-0-1-1--499759bc:12f72c12020:-8000:000000000000147C begin
        
        $returnValue = array(
        	PERSISTENCE_HARD => true, 
        	PERSISTENCE_SMOOTH => true, 
        	PERSISTENCE_VIRTUOSO => false, 
        	PERSISTENCE_SUBSCRIPTION => false
       	);
        
        if (self::isForcedMode()){
        	$returnValue = array (
        		self::$current => true
        	);
        } else if (count ($params)){
        	$returnValue = array_merge($returnValue, $params);
        }
        // section 127-0-1-1--499759bc:12f72c12020:-8000:000000000000147C end

        return (array) $returnValue;
    }

    /**
     * Short description of method isValidContext
     *
     * @abstract
     * @access public
     * @author Jerome Bogaerts, <jerome.bogaerts@tudor.lu>
     * @param  string context
     * @param  Resource resource
     * @return boolean
     */
    public abstract function isValidContext($context,  \core_kernel_classes_Resource $resource);

    /**
     * Force the use of a specific implementation
     *
     * @access public
     * @author Jerome Bogaerts, <jerome.bogaerts@tudor.lu>
     * @param  string implementation
     * @return mixed
     */
    public static function forceMode($implementation)
    {
        // section 127-0-1-1-7a0c731b:12fbfab7535:-8000:000000000000153C begin
        if (!empty($implementation)){
    		self::$implementationHistory[] = self::$current;
    		self::$current = $implementation;
    		\common_Logger::d('Forced persistence "'.self::$current.'"');
    	} else {
    		throw new \common_exception_Error("forceMode called without implementation");
    	}
        // section 127-0-1-1-7a0c731b:12fbfab7535:-8000:000000000000153C end
    }

    /**
     * Short description of method isForcedMode
     *
     * @access public
     * @author Jerome Bogaerts, <jerome.bogaerts@tudor.lu>
     * @param  string implementation
     * @return boolean
     */
    public static function isForcedMode($implementation = '')
    {
        $returnValue = (bool) false;

        // section 127-0-1-1-7a0c731b:12fbfab7535:-8000:000000000000153F begin
        
        if (!empty(self::$current)){
			if(!empty($implementation)){
				$returnValue = ($implementation == self::$current);
			}else{
				$returnValue = true;
			}
        }
        
        // section 127-0-1-1-7a0c731b:12fbfab7535:-8000:000000000000153F end

        return (bool) $returnValue;
    }

    /**
     * Deprecated, please use restoreMode() instead
     *
     * @access public
     * @author Jerome Bogaerts, <jerome.bogaerts@tudor.lu>
     * @deprecated
     * @return mixed
     */
    public function resetMode()
    {
        // section 127-0-1-1-7a0c731b:12fbfab7535:-8000:0000000000001545 begin
		\common_Logger::w('Deprecated function PersistenceProxy::resetMode() called');   	
   		self::$current = "";
    		
        // section 127-0-1-1-7a0c731b:12fbfab7535:-8000:0000000000001545 end
    }

    /**
     * resores the previsous implementation
     *
     * @access public
     * @author Jerome Bogaerts, <jerome.bogaerts@tudor.lu>
     * @return mixed
     */
    public static function restoreImplementation()
    {
        // section 127-0-1-1-6b2ff0f2:135e313546a:-8000:0000000000001967 begin
        if (count(self::$implementationHistory) > 0) {
        	self::$current = array_pop(self::$implementationHistory);
        	\common_Logger::d('Restored persistence "'.self::$current.'"');
        } else {
        	throw new \common_exception_Error("PersistencyProxy::restoreImplementation() called without forcing an implementation first");
        }
        // section 127-0-1-1-6b2ff0f2:135e313546a:-8000:0000000000001967 end
    }

}