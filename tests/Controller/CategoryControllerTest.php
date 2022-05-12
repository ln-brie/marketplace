<?php

namespace App\Tests;

use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    private $client;

    public function setUp():void
    {
        $this->client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        $this->client->loginUser($testUser);
        $this->date = date('y-m-d H:i');
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', '/category');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Catégories');
    }

    public function testAjout() {
        $crawler = $this->client->request('GET', '/add/category');
        $name = 'Nouvelle Categorie';
        $desc = file_get_contents('http://loripsum.net/api/1/short/plaintext');
        $this->client->submitForm('Ajouter', [
            'category[nom]' => $name,
            'category[description]' => $desc 
        ]);
        $this->assertResponseRedirects('/category');
    }

    public function testUpdate() {
        $catRepo = static::getContainer()->get(CategoryRepository::class);
        $test = $catRepo->findOneByNom('Nouvelle Categorie');
        $id = $test->getId();
        $crawler = $this->client->request('GET', '/update/category/'.$id);
        $this->client->submitForm('Valider', [
            'category[nom]' => 'Categorie modifiee'
        ]);

        $this->assertResponseRedirects('/category');
    }

}
