<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Create Contact
        $contact = new Contact();
        $contact->setFirstname("User");
        $contact->setName("Test");
        $contact->setEmail("user-test@gmail.com");
        $contact->setMessage("Hello world");
        // Tell Doctrine that we want to (eventually) register the product (no request yet)
        $manager->persist($contact);
        // Actually executes the queries (i.e. the INSERT query)
        $manager->flush();
    }
}
