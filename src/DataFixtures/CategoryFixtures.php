<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = array('Informatique', 'Gros électroménager', 'Petit électroménager', 'Audiovisuel');
        $desc = file_get_contents('http://loripsum.net/api/1/short/plaintext');
        foreach ($categories as $c ) {
            $category = new Category();
            $category->setNom($c);
            $category->setDescription($desc);
            $manager->persist($category);

            $this->addReference($c, $category);
        }
        

        $manager->flush();
    }
}
