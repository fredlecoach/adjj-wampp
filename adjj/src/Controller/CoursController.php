<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoursController extends AbstractController{

  #[Route("/mushin", name: "mushin")]
  public function mushin(){
    return $this->render("cours/mushin.html.twig");
  }
  #[Route("/jjb", name: "jjb")]
  public function jjb(){
    return $this->render("cours/jjb.html.twig");
  }
  #[Route("/self-defense", name: "self-defense")]
  public function selfDefense(){
    return $this->render("cours/self-defense.html.twig");
  }
  #[Route("/valetudo", name: "valetudo")]
  public function valetudo(){
    return $this->render("cours/valetudo.html.twig");
  }
  #[Route("/jujutsu", name: "jujutsu")]
  public function jujutsu(){
    return $this->render("cours/jujutsu.html.twig");
  }
  #[Route("/zen-hakko-kai", name: "zen")]
  public function zen(){
    return $this->render("cours/zen.html.twig");
  }



}