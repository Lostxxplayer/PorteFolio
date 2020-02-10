<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Project;
use App\Entity\Category;
class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        
        for($i = 1; $i <= 3; $i++){
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());
            $manager->persist($category);
        }
        for($i = 1; $i <= 10; $i++){
            $project = new Project();
            $project->setTitle("Titre du Project n°$i")
                    ->setContent("<p>contenu du Project n°$i</p>")
                    ->setImage("http://placehold.it/350x150")
                    ->setCreatedAt(new \DateTime())
                    ->setCategory($category);
            $manager->persist($project);
        }

        $manager->flush();
    }
}
