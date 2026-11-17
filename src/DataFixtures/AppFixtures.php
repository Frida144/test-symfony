<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Book;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Création d'un objet Faker
        $faker = Faker\Factory::create('fr_FR');

        $categories = [];
        for ($i=0; $i < 20; $i++) { 
            //Créer des objets 
            $category = new Category();
            $category->setName($faker->word());
            $categories[] = $category;
            
            //persister l'objet
            $manager->persist($category);
        }
        $users = [];
        for ($i=0; $i < 10; $i++) { 
            //Créer des objets 
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $users[] = $user;

            //persister l'objet
            $manager->persist($user);
        }
        for ($i=0; $i < 60; $i++) { 
            //Créer des objets 
            $book = new Book();
            $book->setTitle($faker->sentence(3));
            $book->setResume($faker->text(255));
            $book->setPublishAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 week', '+3 days')));
            $book->setAuthor($faker->name());
            $book->setUser($faker->randomElement($users));
            foreach ($faker->randomElements($categories, 5) as $category) {
                $book->addCategory($category);
            }

            //persister l'objet
            $manager->persist($book);
        }

        $manager->flush();
    }
}
