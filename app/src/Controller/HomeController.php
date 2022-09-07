<?php

namespace App\Controller;

use App\Entity\Locations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $db)
    {
    }

    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        $locations = $this->db->getRepository(Locations::class)->findAll();
        if ($this->getUser()) {
            return $this->render('home/home.html.twig', [
                'controller_name' => 'HomeController',
                'locations' => $locations,
            ]);
        }
        return $this->redirectToRoute('app_login');
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_home');
    }
}
