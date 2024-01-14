<?php

// src/DataFixtures/UserFixtures.php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('user@user.fr');
        $user->setFirstName('User');
        $user->setLastName('User');
        $user->setPseudo('user');
        $user->setAdress('1 rue de la rue');
        $user->setCity('Paris');
        $user->setZipCode('75000');
        $user->setCreatedAt(new \DateTime());
        $user->setPassword('$argon2id$v=19$m=65536', 'user');
        $user->setRoles(['ROLE_USER']);

        $manager->persist($user);

        $user = new User();
        $user->setEmail('admin@admin.fr');
        $user->setFirstName('Admin');
        $user->setLastName('Admin');
        $user->setPseudo('admin');
        $user->setAdress('1 rue de la rue');
        $user->setCity('Paris');
        $user->setZipCode('75000');
        $user->setCreatedAt(new \DateTime());
        $user->setPassword('$argon2id$v=19$m=65536', 'admin');
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $manager->flush();
    }
}
