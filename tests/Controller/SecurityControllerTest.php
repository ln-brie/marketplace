<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testNoAccesAddProduct(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/add/product');
        $this->assertResponseRedirects('/login');
    }

    public function testNoAccesAddCategory(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/add/category');
        $this->assertResponseRedirects('/login');
    }

    public function testNoAccesUpdtaeProduct(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/update/product/1');
        $this->assertResponseRedirects('/login');
    }

    public function testNoAccesUpdateCategory(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/update/category/1');
        $this->assertResponseRedirects('/login');
    }

    public function testAccesAddProduct(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/add/product');
        $this->assertResponseIsSuccessful();
    }

    public function testAccesAddCategory(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/add/category');
        $this->assertResponseIsSuccessful();
    }

    public function testAccesUpdateProduct(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/update/product/1');
        $this->assertResponseIsSuccessful();
    }

    public function testAccesUpdateCategory(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/update/category/1');
        $this->assertResponseIsSuccessful();
    }
}
