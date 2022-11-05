<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // return $this->render('security/index.html.twig', [
        //     'controller_name' => 'SecurityController',
        // ]);


        // controller can be blank: it will never be executed!
        throw new \Exception('logout');
    }
}
