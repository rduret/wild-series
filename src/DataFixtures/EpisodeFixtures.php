<?php
namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Service\Slugify;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 30; $i++){
            for($j = 1; $j < 11; $j++){
                $randomData  =  Faker\Factory::create('fr_FR');
                $episode = new Episode();
                $episode->setNumber($j);
                $episode->setTitle($randomData->word);
                $episode->setSynopsis($randomData->paragraph);
                $episode->setSlug($this->slugify->generate($episode->getTitle()));
                $episode->setSeason($this->getReference('season_' . $i));
                $manager->persist($episode);
            }
        }
        $manager->flush();
    }

    public function getDependencies()  
    {
        return [SeasonFixtures::class];
    }
}