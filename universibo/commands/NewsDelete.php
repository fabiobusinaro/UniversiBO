<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('News/NewsItem'.PHP_EXTENSION);

/**
 * NewsDelete: elimina una notizia, mostra il form e gestisce la cancellazione 
 * 
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Daniele Tiles
 * @author Fabrizio Pinto
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class NewsDelete extends CanaleCommand {


	function execute() {
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$user =& $this->getSessionUser();
		$canale =& $this->getRequestCanale();
		
		$referente = false;
		$moderatore = false;
		
				
		$user_ruoli = $user->getRuoli();
		$id_canale = $canale->getIdCanale();
	
		
		if (!array_key_exists('id_news', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_news'] )  )
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'L\'id della notizia richiesta non � valido','file'=>__FILE__,'line'=>__LINE__ ));
		}
		
		/* diritti
		 -admin
		 -autore notizia
		 -referenti canale
		*/
		
		if (array_key_exists($id_canale, $user_ruoli))
		{
			$ruolo = & $user_ruoli[$id_canale];

			$referente = $ruolo->isReferente();
			$moderatore = $ruolo->isModeratore();
		}

		$news = & NewsItem :: selectNewsItem($_GET['id_news']);
		$news-> getIdCanali();
		/*var_dump($news->getNotizia());
		die();
		*/		
		$autore = ($user->getIdUser() == $news->getIdUtente());
		if (!($user->isAdmin() || $referente || ($moderatore && $autore)))
			Error :: throw (_ERROR_DEFAULT, array ('msg' => "Non hai i diritti per eliminare la notizia\n La sessione potrebbe essere scaduta", 'file' => __FILE__, 'line' => __LINE__));
		
		//$elenco_canali = array ($id_canale);
		$ruoli_keys = array_keys($user_ruoli);
		$num_ruoli = count($ruoli_keys);
		for ($i = 0; $i < $num_ruoli; $i ++)
		{
			$elenco_canali[] = $user_ruoli[$ruoli_keys[$i]]->getIdCanale();
		}
		
		$news_canali =& $news->getIdCanali();
		/*var_dump($news_canali );
		die();
		*/
		
		$num_canali = count($news_canali);
		for ($i = 0; $i < $num_canali; $i ++)
		{
			$id_current_canale = $news_canali[$i];
			$current_canale = & Canale :: retrieveCanale($id_current_canale);
			$nome_current_canale = $current_canale->getTitolo();
			if (in_array($id_current_canale, $news->getIdCanali())) 
			{
				$f9_canale[] = array ('id_canale' => $id_current_canale, 'nome_canale' => $nome_current_canale, 'spunta' => 'true');
			}
		}
		
		$f9_accept = false;
		
		//postback
		
		if (array_key_exists('f9_submit', $_POST)  )
		{
			$f9_accept = true;
			
			//controllo diritti su ogni canale di cui � richiesta la cancellazione
			if (array_key_exists('f9_canale', $_POST))
			{
				foreach ($_POST['f9_canale'] as $key => $value)
				{
					$diritti = $user->isAdmin() || (array_key_exists($key, $user_ruoli) && ($user_ruoli[$key]->isReferente() || ($user_ruoli[$key]->isModeratore() && $autore)));
					if (!$diritti)
					{
						//$user_ruoli[$key]->getIdCanale();
						$canale = & Canale :: retrieveCanale($key);
						Error :: throw (_ERROR_NOTICE, array ('msg' => 'Non possiedi i diritti di eliminazione nel canale: '.$canale->getTitolo(), 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
						$f9_accept = false;
					}
				}
			}
			else
			{
				$f9_accept = false;
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Devi selezionare almeno un canale:', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
			}
			
		}
		
		
		//accettazione della richiesta
		if ($f9_accept == true)
		{
//			var_dump($_POST['f9_canale'] );
//			die();
			//cancellazione dai canali richiesti
			foreach ($_POST['f9_canale'] as $key => $value)
				{
					$news->removeCanale($key);
					$canale = Canale::retrieveCanale($key);
					$canale->setUltimaModifica(time(), true);
				}
			
			$news->deleteNewsItem();
			/**
			 * @TODO elenco dei canali dai quali � stata effetivamente cancellata la notizia
			 */
			$template->assign('NewsDelete_langSuccess', "La notizia � stata cancellata dai canali scelti.");
			
			return 'success';
		}
		
		//visualizza notizia
		$param = array('id_notizie'=>array($_GET['id_news']) );
		$this->executePlugin('ShowNews', $param );
		
		$template->assign('f9_langAction', "Elimina la notizia dai seguenti canali:");
		$template->assign('f9_canale', $f9_canale);
		
		return 'default';
	}

}

?>