<?php
namespace App\Controller;

use Doctrine\ORM\EntityRepository;
use App\Repository\InscriptionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/user')]
#[IsGranted('ROLE_USER')]
class AdminController extends AbstractController{

  #[Route("/admin", name: "admin")]
  public function admin(InscriptionRepository $ir): Response{

    $inscription = $ir->findAll();

    return $this->render("Admin/admin.html.twig", ["inscription" => $inscription] );
  }


}