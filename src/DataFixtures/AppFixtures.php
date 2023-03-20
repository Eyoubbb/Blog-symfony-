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

        $colors = ['#d470a2', '#787ef4', '#bf9000', '#44aa99', '#b081c1', '#6aa84f', 'cc0000'];

        foreach ($colors as $color) {
            CategoryFactory::createOne(['color' => $color]);
        }

        UserFactory::createOne(['username' => 'admin', 'plainPassword' => 'admin']);
        UserFactory::createMany(10);

        $manager->flush();
    }
}
