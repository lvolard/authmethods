<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private RouterInterface $router;
    private RequestStack $requestStack;

    public function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function handle(Request $request, \Symfony\Component\Security\Core\Exception\AccessDeniedException $accessDeniedException): ?RedirectResponse
    {
        $session = $this->requestStack->getSession();
        $session->getFlashBag()->add('error', 'You must be an admin to access this area.');

        return new RedirectResponse($this->router->generate('homepage'));
    }
}
