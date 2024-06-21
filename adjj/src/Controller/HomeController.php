<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class HomeController extends AbstractController{

  #[Route("/", name: "home")]//1ère valeur => barre de navigation, 2ème valeur => lien du menu
  public function home(){
  return $this->render("front/home.html.twig");
  }
  #[Route("/cours", name: "cours")]//1ère valeur => barre de navigation, 2ème valeur => lien du menu
  public function cours(){
  return $this->render("front/cours.html.twig");
  }
  #[Route("/professeurs", name: "professeurs")]//1ère valeur => barre de navigation, 2ème valeur => lien du menu
  public function professeurs(){
  return $this->render("front/professeurs.html.twig");
  }
  #[Route("/tarifs", name: "tarifs")]//1ère valeur => barre de navigation, 2ème valeur => lien du menu
  public function tarifs(){
  return $this->render("front/tarifs.html.twig");
  }
  #[Route("/notre_histoire", name: "notre_histoire")]//1ère valeur => barre de navigation, 2ème valeur => lien du menu
  public function notre_histoire(){
  return $this->render("front/notre_histoire.html.twig");
  }
  #[Route("/actualites", name: "actualites")]//1ère valeur => barre de navigation, 2ème valeur => lien du menu
  public function actualites(){
  return $this->render("front/actualites.html.twig");
  }
  #[Route("/stages_competitions", name: "stages_competitions")]//1ère valeur => barre de navigation, 2ème valeur => lien du menu
  public function stages_competitions(){
    $data["h1"]= "Stages et compétitions";
  return $this->render("front/stages_competitions.html.twig", $data);
  }


}