<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setFirstName('Hélène');
        $user->setLastName('Brie');
        $user->setRoles(['ROLE_USER']);
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();
    }
}
