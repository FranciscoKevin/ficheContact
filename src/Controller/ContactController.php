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
     * @var MailerInterface
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
    #[Route('/fiche-contact', name: 'fiche_contact')]
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

            //Message flash after submit email
            $this->addFlash("success", "Votre mail à bien été envoyé. Merci de nous avoir contacté. Un arbre de plus sera planté grâce à vous!");
            return $this->redirectToRoute('home');
        }

        return $this->render('contact/fiche-contact.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * This controller displays all registered contacts
     *
     * @return Response
     */
    #[Route('/contact/index', name: 'contact_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $this->entityManager->getRepository(Contact::class)->findAll(),
        ]);
    }

    /**
     * This controller displays the information of a single contact
     *
     * @return Response
     */
    #[Route('/contact/{id}', name: 'contact_details', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/details.html.twig', [
            'contact' => $contact,
        ]);
    }
}
