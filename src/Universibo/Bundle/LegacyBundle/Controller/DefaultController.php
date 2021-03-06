<?php
namespace Universibo\Bundle\LegacyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Universibo\Bundle\LegacyBundle\Framework\DefaultReceiver;

/**
 * @author Davide Bellettini <davide.bellettini@gmail.com>
 */
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if ($do = $request->query->get('do', $request->attributes->get('redirect') ? 'ShowHome' : null)) {
            return $this->handleLegacy($do, $request);
        }

        $do = $request->attributes->get('do');

        $base = realpath(__DIR__.'/../../../../..');
        $receiver = new DefaultReceiver('main', $base .'/config.xml', $base . '/framework', $base . '/universibo', $this->container, $do);

        $result = $receiver->main($request);

        if ($result instanceof Response) {
            return $result;
        }

        return $this->render('UniversiboLegacyBundle:Default:index.html.twig', $result);
    }

    /**
     * Map legacy urls for google-friendly migration
     *
     * @param  string                $do
     * @throws NotFoundHttpException
     */
    private function handleLegacy($do, Request $request)
    {
        $router = $this->get('router');

        switch ($do) {
            case 'FileDownload':
                return $this->redirect($router->generate('universibo_legacy_file_download', ['id_file' => $request->query->get('id_file')], true), 301);
            case 'FileShowInfo':
                return $this->redirect($router->generate('universibo_legacy_file', ['id_file' => $request->query->get('id_file')], true), 301);
            case 'NewsShowCanale':
                  return $this->redirect($router->generate('universibo_legacy_news_show_canale', ['id_canale' => $request->query->get('id_canale'), 'qta' => $request->query->get('qta'), 'inizio' => $request->query->get('inizio')], true), 301);
            case 'Login':
            case 'NewPasswordStudente':
            case 'RecuperaUsernameStudente':
            case 'RegStudente':
                return $this->redirect($router->generate('login', [], true), 301);
            case 'ShowAccessibility':
                return $this->redirect($router->generate('universibo_legacy_accessibility', [], true), 301);
            case 'ShowCanale':
                return $this->redirect($router->generate('universibo_legacy_canale', ['id_canale' => $request->query->get('id_canale')], true), 301);
            case 'ShowCdl':
                return $this->redirect($router->generate('universibo_legacy_cdl', ['id_canale' => $request->query->get('id_canale')], true), 301);
            case 'ShowCredits':
                return $this->redirect($router->generate('universibo_legacy_credits', [], true), 301);
            case 'ShowCollaboratore':
                $userRepo = $this->get('universibo_core.repository.user');
                $userId = $this->getRequest()->query->get('id_coll');
                $user = $userRepo->find($userId);
                if ($user === null) {
                    throw new NotFoundHttpException('User not found');
                }

                return $this->redirect($router->generate('universibo_legacy_collaborator', ['username' => $user->getUsername()], true), 301);
            case 'ShowContacts':
                return $this->redirect($router->generate('universibo_legacy_contacts', [], true), 301);
            case 'ShowContribute':
                return $this->redirect($router->generate('universibo_legacy_contribute', [], true), 301);
            case 'ShowError':
                return $this->redirect($router->generate('universibo_legacy_error', [], true), 301);
            case 'ShowFacolta':
                return $this->redirect($router->generate('universibo_legacy_facolta', ['id_canale' => $request->query->get('id_canale')], true), 301);
            case 'ShowFileInfo':
                return $this->redirect($router->generate('universibo_legacy_file', ['id_file' => $request->query->get('id_file')], true), 301);
            case 'ShowHelp':
                return $this->redirect($router->generate('universibo_legacy_help', [], true), 301);
            case 'ShowHelpTopic':
                return $this->redirect($router->generate('universibo_legacy_help_topic', [], true), 301);
            case 'ShowHome':
                return $this->redirect($router->generate('universibo_legacy_home', [], true), 301);
            case 'ShowInfoDidattica':
                return $this->redirect($router->generate('universibo_legacy_insegnamento_info', ['id_canale' => $request->query->get('id_canale')], true), 301);
            case 'ShowInsegnamento':
                return $this->redirect($router->generate('universibo_legacy_insegnamento', ['id_canale' => $request->query->get('id_canale')], true), 301);
            case 'ShowManifesto':
                  return $this->redirect($router->generate('universibo_legacy_manifesto', [], true), 301);
            case 'ShowMyUniversiBO':
                  return $this->redirect($router->generate('universibo_legacy_myuniversibo', [], true), 301);
            case 'ShowPermalink':
                return $this->redirect($router->generate('universibo_legacy_permalink', ['id_notizia' => $request->query->get('id_notizia')], true), 301);
            case 'ShowRules':
                return $this->redirect($router->generate('universibo_website_rules', [], true), 301);
            case 'ShowUser':
                return $this->redirect($router->generate('universibo_legacy_user', ['id_utente' => $request->query->get('id_utente')], true), 301);

            default:
                throw new NotFoundHttpException("Legacy do=$do not mapped");
        }
    }
}
