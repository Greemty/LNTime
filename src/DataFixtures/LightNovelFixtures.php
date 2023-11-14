<?php

namespace App\DataFixtures;
use App\Entity\Genre;
use App\Entity\LightNovel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
class LightNovelFixtures extends Fixture
{
    // defines reference names for instances of LightNovels
    private const GENRE_1 = 'Action';
    private const GENRE_2 = 'Aventure';

    /**
     * Generates initialization data for racks : [title]
     * @return \\Generator
     */
    private static function GenreDataGenerator()
    {
        yield ["Action", self::GENRE_1];
        yield ["Aventure", self::GENRE_2];
    }

    /**
     * Generates initialization data for film recommendations:
     *  [film_title, film_year, recommendation]
     * @return \\Generator
     */
    private static function lightnovelGenerator()
    {
        yield [self::GENRE_1, "SYS"];
        yield [self::GENRE_1, "TBATE"];
        yield [self::GENRE_1, "Damn Reincarnation"];
    }

    public function load(ObjectManager $manager)
    {
        $inventoryRepo = $manager->getRepository(Genre::class);

        foreach (self::GenreDataGenerator() as [$title, $GenreReference] ) {
            $genre = new Genre();
            $genre->setcategoryName($title);
            $manager->persist($genre);
            $manager->flush();

            // Once the Rack instance has been saved to DB
            // it has a valid Id generated by Doctrine, and can thus
            // be saved as a future reference
            $this->addReference($GenreReference, $genre);
        }

        foreach (self::lightnovelGenerator() as [$rackReference, $model])
        {
            $genre = $this->getReference($GenreReference);
            $lightnovel = new LightNovel();
            $lightnovel->setTitle($model);
            $genre->addLightNovel($lightnovel);

            $manager->persist($lightnovel);
        }
        $manager->flush();
    }
}
