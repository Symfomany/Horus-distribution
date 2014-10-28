<?php

namespace  Horus\BackendBundle\Authentication;

use Symfony\Component\Routing\RouterInterface,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Request,
    Doctrine\ORM\EntityManager,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
    Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface,
    Symfony\Component\Security\Core\Authentication\Token\TokenInterface,
    Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Component\Security\Core\Exception\AuthenticationException,
    Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

use Doctrine\Common\Util\Debug as Debug;

/**
 * Class AuthenticationSiteHandler
 * @package Horus\BackendBundle\Authentication
 */
class AuthenticationSiteHandler implements LogoutSuccessHandlerInterface, AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface {

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Constructor Dependances
     * @param RouterInterface $router
     * @param EntityManager $em
     * @param Session $session 
     */
    public function __construct(RouterInterface $router, EntityManager $em, Session $session) {
        $this->router = $router;
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * Method Authentification Sucess
     * @param Request $request
     * @param TokenInterface $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse 
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {

    }

    /**
     * Auth Failed
     * @param Request $request
     * @param AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\RedirectResponse 
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {

        $referer = $request->headers->get('referer');
        $request->getSession()->setFlash('error', $exception->getMessage());
        return new RedirectResponse($referer);
    }

    /**
     * Logout Params
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function onLogoutSuccess(Request $request) {
        $referer_url = $request->headers->get('referer');

        $referer_url = $this->router->generate('horus_site_main');
        $response = new RedirectResponse($referer_url);
        return $response;
    }

}


?>
