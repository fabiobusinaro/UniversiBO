<?php

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * ShowHome: mostra la homepage
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */


class ShowHome extends CanaleCommand 
{
	
	/** 
	 * Inizializza il comando ShowHome ridefinisce l'initCommand() di CanaleCommand
	 */
	function initCommand( &$frontController )
	{
		
		parent::initCommand( $frontController );
		
		$canale =& $this->getRequestCanale();
		//var_dump($canale);
		
		if ( $canale->getTipoCanale() != CANALE_HOME )
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Il tipo canale richiesto non corrisponde al comando selezionato','file'=>__FILE__,'line'=>__LINE__));
				
	}


	function execute()
	{
		$template =& $this->frontController->getTemplateEngine();
		
		$template->assign('home_langWelcome', 'Benvenuto in UniversiBO!');
		$template->assign('home_langWhatIs', 'Questo � il nuovo portale per la didattica, dedicato agli studenti dell\'universit� di Bologna.');
		$template->assign('home_langMission', 'L\'obiettivo verso cui � tracciata la rotta delle iniziative e dei servizi che trovate su questo portale � di "aiutare gli studenti ad aiutarsi tra loro", fornirgli un punto di riferimento centralizzato in cui prelevare tutte le informazioni didattiche riguardanti i propri corsi di studio e offrire un mezzo di interazione semplice e veloce con i docenti che partecipano all\'iniziativa.');
		
		return 'default';
	}

}

?>