<?php
namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
/*     const ACTORS = [
        "Andrew Lincoln",
        "Norman Reedus",
        "Lauren Cohan",
        "Chandler Riggs",
        "Danai Gurira",
        "Melissa McBride"
    ]; */

    public function load(ObjectManager $manager)
    {
        for($i=0; $i<6; $i++){
            for($j=0; $j < 10; $j++){
                $randomData  =  Faker\Factory::create('fr_FR');
                $actor = new Actor();
                $actor->setName($randomData->name);
                $actor->addProgram($this->getReference('program_' . $i));
                $manager->persist($actor);
            }
        }

        $manager->flush();
    }

    public function getDependencies()  
    {
        return [ProgramFixtures::class];
    }
}