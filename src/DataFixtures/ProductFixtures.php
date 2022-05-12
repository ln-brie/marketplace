<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $desc = file_get_contents('http://loripsum.net/api/1/short/plaintext');
        $categories = array('Informatique', 'Gros électroménager', 'Petit électroménager', 'Audiovisuel');
        $state = array('Bon', 'Moyen', 'Mauvais');
        for($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('produit '.$i);
            $product->setPrice(rand(10, 400));
            $product->setDescription($desc);
            $product->setCategory($this->getReference($categories[rand(0,3)]));
            $product->setState($state[rand(0,2)]);
            $manager->persist($product);
        }
        

        $manager->flush();
    }

    public function getDependencies() {
        return [
            CategoryFixtures::class
        ];
    }
}
