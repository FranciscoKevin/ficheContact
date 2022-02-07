<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
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
        foreach (self:: DEPARTMENT_OF_COMPANY as $departments) {
            $company = new Company();
            $company->setDepartmentName($departments["name"]);
            $company->setEmail($departments["email"]);
            $manager->persist($company);
        }
        $manager->flush();
    }
}
