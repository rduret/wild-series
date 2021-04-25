<?php
namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $k = 0;
        for($i = 0; $i < 6; $i++){
            for($j = 1; $j < 6; $j++){
                $randomData  =  Faker\Factory::create('fr_FR');
                $season = new Season();
                $season->setNumber($j);
                $season->setYear(2015 + $j);
                $season->setDescription($randomData->paragraph);
                $season->setProgram($this->getReference('program_' . $i));
                $manager->persist($season);
                $this->addReference('season_' . $k, $season);
                $k++;
            }
        }
        $manager->flush();
    }

    public function getDependencies()  
    {
        return [ProgramFixtures::class];
    }
}