<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminUserFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public static function getGroups(): array
    {
        return ['admin'];
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User;

        $admin->setName('Admin');
        $admin->setEmail('admin@example.com');
        $admin->setIsVerified(true);
        $admin->setPassword(
            $this->hasher->hashPassword($admin, 'Louvre')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $manager->flush();
    }
}
