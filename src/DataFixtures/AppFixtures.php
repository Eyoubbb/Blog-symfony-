<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        UserFactory::createOne(['username' => 'admin', 'plainPassword' => 'admin', 'roles' => ['ROLE_ADMIN']]);
        UserFactory::createMany(10);

        PostFactory::createMany(100, ['categories' => CategoryFactory::new()->many(3)]);

        $manager->flush();
    }
}
