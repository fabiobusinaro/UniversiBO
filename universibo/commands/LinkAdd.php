<?php    

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('Files/FileItem'.PHP_EXTENSION);

/**
 * LinkAdd: si occupa dell'inserimento di un link in un canale
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Daniele Tiles
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class LinkAdd extends UniversiboCommand {

	function execute() {

		$frontcontroller = & $this->getFrontController();
		$template = & $frontcontroller->getTemplateEngine();

		$krono = & $frontcontroller->getKrono();
		$user = & $this->getSessionUser();
		$user_ruoli = & $user->getRuoli();

		if ($user->isOspite())
		{
			Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUser(), 'msg' => "Per questa operazione bisogna essere registrati\n la sessione potrebbe essere terminata", 'file' => __FILE__, 'line' => __LINE__));
		}		
/*		if (!array_key_exists('id_canale', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_canale']))
		{
			Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUser(), 'msg' => 'L\'id del canale richiesto non ? valido', 'file' => __FILE__, 'line' => __LINE__));
		}

		$canale = & Canale::retrieveCanale($_GET['id_canale']);
		$id_canale = $canale->getIdCanale();
		$template->assign('common_canaleURI', $canale->showMe());
		$template->assign('common_langCanaleNome', $canale->getTitolo());
*/
		$template->assign('common_canaleURI', array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : '' );
		$template->assign('common_langCanaleNome', 'indietro');
				
		$referente = false;
		$moderatore = false;

		// valori default form
		$f29_URI = '';
		$f29_Label = '';
		$f29_Description = '';
			
		$f29_accept = false;
			
		if (!array_key_exists('id_canale', $_GET))
			Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUser(), 'msg' => 'Devi specificare un id del canale', 'file' => __FILE__, 'line' => __LINE__));
		
		if (!ereg('^([0-9]{1,9})$', $_GET['id_canale']))
			Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUser(), 'msg' => 'L\'id del canale richiesto non ? valido', 'file' => __FILE__, 'line' => __LINE__));

		$canale = & Canale::retrieveCanale($_GET['id_canale']);
		
		if ($canale->getServizioLinks() == false) 
			Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUser(), 'msg' => "Il servizio links ? disattivato", 'file' => __FILE__, 'line' => __LINE__));
	
		$id_canale = $canale->getIdCanale();
		$template->assign('common_canaleURI', $canale->showMe());
		$template->assign('common_langCanaleNome', 'a '.$canale->getTitolo());
		if (array_key_exists($id_canale, $user_ruoli)) {
			$ruolo = & $user_ruoli[$id_canale];

			$referente = $ruolo->isReferente();
			$moderatore = $ruolo->isModeratore();
		}
		
		if (!array_key_exists('f29_URI', $_POST) || !array_key_exists('f29_Label', $_POST) || !array_key_exists('f29_Description', $_POST))
			Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUser(), 'msg' => 'Il form inviato non � valido', 'file' => __FILE__, 'line' => __LINE__));
			
		if (!ereg('(^(http(s)?|ftp)://|^.{0}$)', $_POST['f29_URI']))
			{
				$f29_accept = false;
				Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getIdUser(), 'msg' => 'L\'URL del link alla pagina degli obiettivi deve iniziare con https://, http:// o ftp://, verificare di non aver lasciato spazi vuoti', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
			}
		else $f29_accept = true;
		
		if (!ereg('(^(http(s)?|ftp)://|^.{0}$)', $_POST['f29_URI']))
			{
				$f29_accept = false;
				Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getIdUser(), 'msg' => 'L\'URL del link alla pagina degli obiettivi deve iniziare con https://, http:// o ftp://, verificare di non aver lasciato spazi vuoti', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
			}
		else $f29_accept = true;
	}
	
	
	?>