<?php

/**
 * The receiver. Code to activate the framework system
 * 
 * @package framework
 * @version 1.0.0
 * @author  Deepak Dutta, http://www.eocene.net, Ilias Bartolini
 * @copyright UniversiBO 2001-2003
 */
class Receiver{

	var $frameworkPath = '../framework';
	var $applicationPath = '../universibo';

	var $configFile = '../config.xml';
	
	/**
 	* Set PHP language settings (path, gpc, etc...)
	*/
	function _setPhpEnvirorment()
	{
		
		session_start();
		if (!array_key_exists('SID',$_SESSION) )
		{
			$_SESSION['SID'] = SID;
		}
		// echo SID,' - ' ,$_SESSION['SID'];
				
		$pathDelimiter=( strstr(strtoupper($_ENV['OS']),'WINDOWS') ) ? ';' : ':' ;
		ini_set('include_path', $this->frameworkPath.$pathDelimiter.$this->applicationPath.$pathDelimiter.ini_get('include_path'));
		
		error_reporting(E_ALL);
		
		if ( get_magic_quotes_runtime() == 1 )
		{
			 set_magic_quotes_runtime(0);
		} 
		
		define ('PHP_EXTENSION', '.php');
		
	}
	
	
	/**
 	* Main code for framework activation, includes Error definitions
 	* and instantiates FrontController
	*/
	function main()
	{
		$this->_setPhpEnvirorment();
				
		include_once('FrontController'.PHP_EXTENSION);
		$fc= new FrontController($this->configFile);
		
		//$smarty =& $fc->getTemplateEngine();
		
		//var_dump($smarty);
		
		//$response = $fc->executeCommand( $request );
		$fc->executeCommand();
		
		//modifica brain
		//echo $fc->response->content;
		
	}

}

$receiver = new Receiver;
$receiver->main();


?>


