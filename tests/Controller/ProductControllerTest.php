<?php

namespace App\Tests;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        $this->client->loginUser($testUser);
        $this->date = date('y-m-d H:i');
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', '/product');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Nos articles reconditionnés');
    }

    public function testAjout()
    {
        $crawler = $this->client->request('GET', '/add/product');
        $name = 'Nouveau produit';
        $desc = file_get_contents('http://loripsum.net/api/1/short/plaintext');
        $this->client->submitForm('Ajouter', [
            'product[name]' => $name,
            'product[description]' => $desc,
            'product[price]' => 10,
            'product[state]' => 'Bon',
            'product[category]' => 4
        ]);
        $this->assertResponseRedirects('/product');
    }

    public function testUpdate()
    {
        $prodRepo = static::getContainer()->get(ProductRepository::class);
        $test = $prodRepo->findOneByName('Nouveau produit');
        $id = $test->getId();
        $crawler = $this->client->request('GET', '/update/product/' . $id);
        $this->client->submitForm('Valider', [
            'product[name]' => 'Produit modifie'
        ]);

        $this->assertResponseRedirects('/product');
    }
}
