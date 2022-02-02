<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class ContactController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var $mailer
     */
    private $mailer;

    // Dependency Injections
    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    /**
     * This controller creates the form, retrieves the data and sends the email
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/fiche-contact', name: 'contact')]
    public function contact(Request $request): Response
    {
        // Set up a fresh $contact object 
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        // Retrives some data
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$contact variable has also been updated
            $contact = $form->getData();
            $this->entityManager->persist($contact);
            // Flush the persisted object
            $this->entityManager->flush();

            //Create object Mailer
            $email = (new Email())
                ->from($contact->getEmail())
                ->to($contact->getDepartment()->getEmail())
                ->subject("Nouveau mail au pole " . $contact->getDepartment()->getDepartmentName())
                //Templating email with data
                ->html($this->renderView('contact/email.html.twig', [
                    'fullname' => $contact->getName(). " " .$contact->getFirstname(),
                    "email" => $contact->getEmail(),
                    "department" => $contact->getDepartment()->getDepartmentName(),
                    "message" => $contact->getMessage()
            ]));
            // Send mail
            $this->mailer->send($email);

            $this->addFlash("message", "Votre mail à bien été envoyé. Merci de nous avoir contacté.");
            return $this->redirectToRoute('home');
        }

        return $this->render('contact/fiche-contact.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
