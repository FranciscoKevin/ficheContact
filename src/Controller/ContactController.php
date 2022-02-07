<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private MailerService $mailerService;

    /**
     * ContactController constructor.
     *
     * @param EntityManagerInterface $entityManager;
     * @param MailerService $mailerService
     */
    public function __construct(EntityManagerInterface $entityManager, MailerService $mailerService)
    {
        $this->entityManager = $entityManager;
        $this-> mailerService = $mailerService;
    }

    /**
     * This controller displays the homepage to browse the contact card and see all the contacts
     *
     * @return Response
     */
    #[Route('/', name: 'home_contact')]
    public function homepage(): Response
    {
        return $this->render('contact/homepage.html.twig');
    }

    /**
     * This controller creates the form, retrieves the data and sends the email
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/fiche-contact', name: 'fiche_contact')]
    public function createContact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            $this->mailerService->send(
                from: $contact->getEmail(),
                to: $contact->getDepartment()->getEmail(),
                subject: "Nouveau mail au pole " . $contact->getDepartment()->getDepartmentName(),
                template: "contact/email.html.twig",
                parameters:
                [
                    "fullname" => $contact->getName(). " " .$contact->getFirstname(),
                    "email" => $contact->getEmail(),
                    "department" => $contact->getDepartment()->getDepartmentName(),
                    "message" => $contact->getMessage(),
                ]
            );
            $this->addFlash("success", "Votre mail à bien été envoyé. Merci de nous avoir contacté. Un arbre de plus sera planté grâce à vous!");
            return $this->redirectToRoute('home');
        }
        return $this->render('contact/fiche_contact.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * This controller displays all registered contacts
     *
     * @return Response
     */
    #[Route('/contact/tous-les-contacts', name: 'show_all_contact', methods: ['GET'])]
    public function showAllContact(): Response
    {
        return $this->render('contact/show_all.html.twig', [
            'contacts' => $this->entityManager->getRepository(Contact::class)->findAll(),
        ]);
    }

    /**
     * This controller displays the information of a single contact
     *
     * @return Response
     */
    #[Route('/contact/details/{id}', name: 'contact_details', methods: ['GET'])]
    public function contactDetails(Contact $contact): Response
    {
        return $this->render('contact/details.html.twig', [
            'contact' => $contact,
        ]);
    }
}
