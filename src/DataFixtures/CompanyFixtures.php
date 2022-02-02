<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    // A multidimensional array with department name and email
    public const DEPARTMENT_OF_COMPANY = [
        'department_1' => [
            "name" => "Direction",
            "email" => "direction@itefficience.com"
            
        ],
        'department_2' => [
            "name" => "Ressouces humaines",
            "email" => "ressources-humaines@itefficience.com"
        ],
        'department_3' => [
            "name" => "Développement",
            "email" => "developpement@itefficience.com"
            
        ],
        'department_4' => [
            "name" => "Communication",
            "email" => "communication@itefficience.com"
        ],

        'department_5' => [
            "name" => "Secrétariat",
            "email" => "secretariat@itefficience.com"
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        // Loops through the iterable_expression array. 
        // On each iteration, the value of the current element is assigned to $departments.
        foreach (self:: DEPARTMENT_OF_COMPANY as $departments) {
            //Create Company
            $company = new Company();
            $company->setDepartmentName($departments["name"]);
            $company->setEmail($departments["email"]);
            // Tell Doctrine that we want to (eventually) register the product (no request yet)
            $manager->persist($company);
        }
        // Actually executes the queries (i.e. the INSERT query)
        $manager->flush();
    }
}
