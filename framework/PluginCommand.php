<?php

/**
 * PluginCommand is the abstract super class of all plugin command classes.
 *
 * Plugin Commands are sub commands called from a BaseCommand implementation.
 * Usually they are associated to a (sub)template that must be included in 
 * the main template
 *
 * @package framework
 * @version 1.1.0
 * @author  Ilias Bartolini <brain79@virgilio.it>
 * @license {@link http://www.opensource.org/licenses/gpl-license.php}
 */
class PluginCommand 
{
	
	/**
	 * @private
	 */
	var $baseCommand;

	/**
	 * 
	 * @param BaseCommand $baseCommand BaseCommand chiamante del plugin
	 */ 
	function PluginCommand( &$baseCommand)
	{
		$this->baseCommand =& $baseCommand;
	}
	
	
	/**
	 * Abstract method must be overridden from sons-classes
	 *
	 * @param mixed $param optional parameter, must be handled from the chosen implementation of PluginCommand
	 */ 
	function execute($param=NULL)
	{
		Error::throwError(_ERROR_CRITICAL,array('msg'=>'Il metodo execute del command deve essere ridefinito','file'=>__FILE__,'line'=>__LINE__) );
	}
	
	
	/**
	 * Return the caller BaseCommand
	 *
	 * @return BaseCommand
	 */ 
	function &getBaseCommand()
	{
		return $this->baseCommand;
	}

	/**
	 * Executes a sub PluginComand
	 *
	 * @param string $name identifier name for this plugin
	 * @param mixed $param a parameter handled by PluginCommand 
	 * @return mixed return value of plugin
	 */ 
	function executePlugin($name, $param)
	{
		$bc =& $this->getBaseCommand();
		$fc =& $bc->getFrontController();
		return $fc->executePlugin($name, $bc, $param);
	}
	
	
}

?>