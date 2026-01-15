<?php

namespace App\Test\Repository;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;


/**
 * Description of CategorieRepositoryTest
 *
 * @author enzog
 */
class CategorieRepositoryTest extends KernelTestCase
{
    public function recupRepository(): CategorieRepository
    {
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    public function newCategorie(): Categorie
    {
        $categorie = (new Categorie())
                ->setName("test");
        return $categorie;
    }
    
    private function getEntityManager()
    {
        return self::getContainer()->get('doctrine')->getManager();
    }
    
    public function testAjoutCategorie(): void
    {
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $nbCategorie = $repository->count([]);
        $repository->add($categorie, true);
        $this->assertEquals($nbCategorie + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testSuppressionCategorie(): void
    {
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $nbCategorie = $repository->count([]);
        $repository->remove($categorie, true);
        $this->assertEquals($nbCategorie - 1, $repository->count([]), "erreur lors de la suppression"); 
    }
    
    public function testFindAllForOnePlaylist(): void
    {
        $repository = $this->recupRepository();
        $em = $this->getEntityManager();

        $playlist = (new Playlist())->setName('Playlist test');
        $em->persist($playlist);

        $formation = (new Formation())
            ->setTitle('Formation test')
            ->setPlaylist($playlist)
            ->setPublishedAt(new DateTime("2024-04-24"));
        $em->persist($formation);

        $categorie1 = $this->newCategorie('TestCategorie1');
        $categorie1->addFormation($formation);

        $categorie2 = $this->newCategorie('TestCategorie2');
        $categorie2->addFormation($formation);

        $em->persist($categorie1);
        $em->persist($categorie2);
        $em->flush();

        $result = $repository->findAllForOnePlaylist($playlist->getId());

        $this->assertCount(2, $result);
    }
}
