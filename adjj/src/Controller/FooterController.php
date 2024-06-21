<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FooterController extends AbstractController{

  #[Route("/ecoles", name: "ecoles")]
  public function ecole(){
    return $this->render("footer/ecoles.html.twig");
  }
  #[Route("/origines", name: "origines")]
  public function origines(){
    return $this->render("footer/origines.html.twig");
  }
  #[Route("/code-honneur", name: "code")]
  public function code(){
    return $this->render("footer/code-honneur.html.twig");
  }
  #[Route("/planning", name: "planning")]
  public function planning(){
    return $this->render("footer/planning.html.twig");
  }

}