<?php

namespace Universibo\Bundle\SSOBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Davide Bellettini <davide.bellettini@gmail.com>
 */
class UserBoxController
{
    private $infoUrl;

    private $logoutUrl;

    private $templating;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $afterLogoutRoute;

    public function __construct($infoUrl, $logoutUrl, $templating, RouterInterface $router, $afterLogoutRoute)
    {
        $this->infoUrl = $infoUrl;
        $this->logoutUrl = $logoutUrl;
        $this->templating = $templating;
        $this->router = $router;
        $this->afterLogoutRoute = $afterLogoutRoute;
    }

    public function indexAction(Request $request)
    {
        $context = $this->get('security.context');
        $claims = $request->getSession()->get('shibbolethClaims', array());

        $hasClaims = count($claims) > 0;
        $logged = $context->isGranted('IS_AUTHENTICATED_FULLY');
        $failed = $hasClaims && !$logged;

        $wreply = '?wreply='.urlencode($this->generateUrl('homepage', array(), true));
        $logoutUrl = $failed ? $this->logoutUrl.$wreply : $this->generateUrl('universibo_shibboleth_prelogout');

        if ($hasClaims) {
            $eppn = $claims['eppn'];
        } elseif ($logged) {
            $eppn = $context->getToken()->getUser()->getEmail();
        } else {
            $eppn = '';
        }

        $data = array (
            'eppn' => $eppn,
            'showEppn' => $eppn !== '',
            'logoutUrl' => $logoutUrl
        ) ;

        return $this->templating->renderResponse('UniversiboSSOBundle:UserBox:index.html.twig', $data);
    }
}
