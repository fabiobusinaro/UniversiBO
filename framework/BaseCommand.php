<?php
/**
 * BaseCommand is the abstract super class of all command classes.
 *
 * @package framework
 * @version 1.1.0
 * @author  Ilias Bartolini
 * @license {@link http://www.opensource.org/licenses/gpl-license.php}
 */
class BaseCommand {
	
	/**
	 * @private
	 */
	var $frontController;

	/**
	 * Initializes the base command link to fornt controller
	 * 
	 * This method must be called from son classes
	 * parent::initCommand();
	 *
	 * @param FrontController $frontController
	 */ 
	function initCommand( &$frontController )
	{
		$this->frontController =& $frontController;
	}
	
	
	/**
	 * Abstract method must be overridden from sons-classes
	 *
	 * @return string template identifier if command uses template engine
	 */ 
	function execute()
	{
		Error::throw(_ERROR_CRITICAL,array('msg'=>'Il metodo execute del command deve essere ridefinito','file'=>__FILE__,'line'=>__LINE__) );
	}
	
	
	/**
	 * Initializes the base command link to fornt controller
	 * 
	 * This method must be overridden from Commands that need shutdown
	 *
	 * @param FrontController $frontController
	 */ 
	function shutdownCommand()
	{

		while ( ($current_error = Error::retrieve(_ERROR_NOTICE)) !== false )
		{
			echo $current_error->throw();
		}

		while ( ($current_error = Error::retrieve(_ERROR_DEFAULT)) !== false )
		{
			echo $current_error->throw();
		}

	}



	/**
	 * Return front controller
	 *
	 * @return FrontController
	 */ 
	function &getFrontController()
	{
		return $this->frontController;
	}

}

?>