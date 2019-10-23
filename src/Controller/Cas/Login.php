<?php

declare(strict_types=1);

namespace drupol\CasBundle\Controller\Cas;

use drupol\psrcas\CasInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class Login.
 */
class Login extends AbstractController
{
    /**
     * @Route("/cas/login", name="cas_bundle_login")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \drupol\psrcas\CasInterface $cas
     *
     * @return \Psr\Http\Message\ResponseInterface|\Symfony\Component\HttpFoundation\RedirectResponse|null
     */
    public function __invoke(
        Request $request,
        CasInterface $cas
    ) {
        $parameters = [
            'renew' => null !== $this->getUser(),
            'service' => $request->headers->get('referer') ??
            $this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ];

        if (null !== $response = $cas->login($parameters)) {
            return $response;
        }

        return new RedirectResponse('/');
    }
}
