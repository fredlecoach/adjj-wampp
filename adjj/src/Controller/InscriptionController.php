<?php
namespace App\Controller;

use App\Entity\Inscription;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class InscriptionController extends AbstractController
{
    #[Route("/inscription", name: "inscription")]
    public function inscription(EntityManagerInterface $em, Request $request, MailerInterface $mailer)
    {
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             /** @var UploadedFile $imageFile */
             $imageFile = $form->get('rib')->getData();

              // Obtenez les données du formulaire à envoyer par mail
             $data = $form->getData();
    
             if ($imageFile) {
                 $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                 
                 // Génération d'un nom de fichier unique
                 $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
     
                 // Déplacement de l'image dans le répertoire de destination
                 try {
                     $imageFile->move(
                         $this->getParameter('uploads_directory'),
                         $newFilename
                     );
                 } catch (FileException $e) {
                     // Gérer les erreurs d'upload
                 }
     
                 // Stocker le nom de fichier dans l'entité inscription
                 $inscription->setRib($newFilename);
             }
     
            $em->persist($inscription);
            $em->flush();


            // Envoyer un e-mail avec les données du formulaire
            $email = (new Email())
            ->from($data->getEmail())  // on récupère l'adresse de l'expéditeur
            ->to('f.roblot.coulanges@gmail.com')  // Adresse du destinataire
            ->subject('Nouvelle Inscription')
            ->html("
                <h2>Nouvelle Inscription</h2>
                <p><strong>Nom:</strong> {$inscription->getNom()}</p>
                <p><strong>Prénom:</strong> {$inscription->getPrenom()}</p>
                <p><strong>Adresse:</strong> {$inscription->getAdresse()}</p>
                <p><strong>Téléphone:</strong> {$inscription->getTelephone()}</p>
                <p><strong>Email:</strong> {$inscription->getEmail()}</p>
                <p><strong>Disciplines:</strong> {$inscription->getDisciplines()}</p>
                <p><strong>Commentaires:</strong> {$inscription->getCommentaires()}</p>
            ")
            ->attachFromPath(
                $this->getParameter('uploads_directory') . '/' . $inscription->getRib(),
                'Fichier RIB'
            );  // Joindre le fichier

            // Envoyer l'e-mail
            $mailer->send($email);


            // Ajouter un message flash pour indiquer que le formulaire a été soumis avec succès
            $this->addFlash('success', 'Votre inscription a été enregistrée avec succès. Nous vous contacterons dans les plus brefs délais !');

            return $this->redirectToRoute("home");
        }

        return $this->render("front/inscription.html.twig", ["form" => $form->createView()]);
    }


}