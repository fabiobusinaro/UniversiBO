<?php


require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('Links/Link'.PHP_EXTENSION);

/**
 * ShowLinks � un'implementazione di PluginCommand.
 *
 * Mostra i link 
 * Il BaseCommand che chiama questo plugin deve essere un'implementazione di CanaleCommand.
 * Nel parametro di ingresso del deve essere specificato il numero di notizie da visualizzare.
 *
 * @package universibo
 * @subpackage Links
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowLink extends PluginCommand {
	
	
	/**
	 * Esegue il plugin
	 *
	 * @param array $param deve contenere: 
	 *  - 'num' il numero di link da visualizzare
	 *	  es: array('num'=>5) 
	 */
	function execute($param)
	{
		
		$id_canale  =  $param['id_canale'];
		$id_link = $param['id_link'];

		$bc        =& $this->getBaseCommand();
		$user      =& $bc->getSessionUser();
		$canale    =& Canale::retrieveCanale($id_canale);
		$fc        =& $bc->getFrontController();
		$template  =& $fc->getTemplateEngine();
		$user_ruoli =& $user->getRuoli();
		

		$id_canale = $canale->getIdCanale();
		$ultima_modifica_canale =  $canale->getUltimaModifica();

		$template->assign('showLinks_adminLinksFlag', 'false');
		if (array_key_exists($id_canale, $user_ruoli) || $user->isAdmin())
		{
			$personalizza = true;
			
			if (array_key_exists($id_canale, $user_ruoli))
			{
				$ruolo =& $user_ruoli[$id_canale];
				
				$referente      = $ruolo->isReferente();
				$moderatore     = $ruolo->isModeratore();
				$ultimo_accesso = $ruolo->getUltimoAccesso();
			}
		
		}
		else
		{
			$personalizza   = false;
			$referente      = false;
			$moderatore     = false;
			$ultimo_accesso = $user->getUltimoLogin();
		}
		
		$link =& Link::selectLink($id_link);
		
		$link_tpl['uri']       		= $link->getUri();
		$link_tpl['label']      	= $link->getLabel();
		$link_tpl['description']    = $link->getDescription();
		$link_tpl['userlink']    = 'index.php?do=ShowUser&id_utente='.$link->getIdUtente();
		$link_tpl['user']    = $link->getUsername();
	

		$template->assign('showSingleLink', $link_tpl);	
		
	}
		
}

?>