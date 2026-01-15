<?php

namespace App\Test\Repository;

use App\Entity\Formation;
use App\Entity\Playlist;
use App\Repository\FormationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationRepositoryTest
 *
 * @author enzog
 */
class FormationRepositoryTest extends KernelTestCase
{
    public function recupRepository(): FormationRepository
    {
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    private function getEntityManager()
    {
        return self::getContainer()->get('doctrine')->getManager();
    }
    
    public function testAjoutFormation(): void
    {
        $repository = $this->recupRepository();
        $em = $this->getEntityManager();

        $nbFormation = $repository->count([]);
        
        $playlist = (new Playlist())->setName('Playlist test');
        $em->persist($playlist);

        $formation = (new Formation())
            ->setTitle('Formation test')
            ->setPlaylist($playlist)
            ->setPublishedAt(new DateTime("2024-04-24"));
        $em->persist($formation);

        $em->flush();
        
        $this->assertEquals($nbFormation + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testSuppressionFormation(): void
    {
        $repository = $this->recupRepository();
        $em = $this->getEntityManager();
        
        $playlist = (new Playlist())
            ->setName('Playlist test');
        $em->persist($playlist);

        $formation = (new Formation())
            ->setTitle('Formation test')
            ->setPlaylist($playlist)
            ->setPublishedAt(new DateTime("2024-04-24"));
        $em->persist($formation);

        $em->flush();
        
        $nbFormation = $repository->count([]);

        $repository->remove($formation, true);
        
        $this->assertEquals($nbFormation - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindAllOrderBy(): void
    {
        $repository = $this->recupRepository();
        $em = $this->getEntityManager();

        $playlist = (new Playlist())
                ->setName('testPlaylist');
        $em->persist($playlist);

        $formation1 = (new Formation())
                ->setTitle('Z Formation')
                ->setPlaylist($playlist)
                ->setPublishedAt(new DateTime("2024-04-24"));
        $formation2 = (new Formation())
                ->setTitle('A Formation')
                ->setPlaylist($playlist)
                ->setPublishedAt(new DateTime("2024-04-24"));

        $em->persist($formation1);
        $em->persist($formation2);
        $em->flush();

        $resultASC = $repository->findAllOrderBy('title', 'ASC');
        $this->assertEquals('A Formation', $resultASC[0]->getTitle());

        $resultDESC = $repository->findAllOrderBy('title', 'DESC');
        $this->assertEquals('Z Formation', $resultDESC[0]->getTitle());
    }
    
    public function testFindByContainValue(): void 
    {
        $repository = $this->recupRepository();
        $em = $this->getEntityManager();
        
        $playlist = (new Playlist())
                ->setName('testPlaylist');
        $em->persist($playlist);

        $formation = (new Formation())
                ->setTitle('TestFormation')
                ->setPlaylist($playlist)
                ->setPublishedAt(new DateTime("2024-04-24"));
        
        $em->persist($formation);
        $em->flush();
        
        $result = $repository->findByContainValue('title', 'TestF');
        $this->assertEquals('TestFormation', $result[0]->getTitle());
    }
    
    public function testFindAllLasted(): void
    {
        $repository = $this->recupRepository();
        $em = $this->getEntityManager();

        $playlist = (new Playlist())
                ->setName('testPlaylist');
        $em->persist($playlist);

        $formation1 = (new Formation())
                ->setTitle('Formation1')
                ->setPlaylist($playlist)
                ->setPublishedAt(new DateTime("2026-01-12"));
        $formation2 = (new Formation())
                ->setTitle('Formation2')
                ->setPlaylist($playlist)
                ->setPublishedAt(new DateTime("2026-01-11"));
        $formation3 = (new Formation())
                ->setTitle('Formation3')
                ->setPlaylist($playlist)
                ->setPublishedAt(new DateTime("2026-01-10"));

        $em->persist($formation1);
        $em->persist($formation2);
        $em->persist($formation3);
        $em->flush();
        
        $result = $repository->findAllLasted(3);
        $this->assertEquals('Formation1', $result[0]->getTitle());
        $this->assertEquals('Formation2', $result[1]->getTitle());
        $this->assertEquals('Formation3', $result[2]->getTitle());
    }
    
    public function testFindAllForOnePlaylist(): void
    {
        $repository = $this->recupRepository();
        $em = $this->getEntityManager();
        
        $playlist = (new Playlist())
                ->setName('testPlaylistSpecial');
        $em->persist($playlist);
        
        $formation1 = (new Formation())
                ->setTitle('Formation1')
                ->setPlaylist($playlist)
                ->setPublishedAt(new DateTime("2026-01-1"));
        $formation2 = (new Formation())
                ->setTitle('Formation2')
                ->setPlaylist($playlist)
                ->setPublishedAt(new DateTime("2026-01-1"));
        
        $em->persist($formation1);
        $em->persist($formation2);
        $em->flush();
        
        $idPlaylist = $playlist->getId();
        
        $result = $repository->findAllForOnePlaylist($idPlaylist);
        $this->assertEquals('Formation1', $result[0]->getTitle());
        $this->assertEquals('Formation2', $result[1]->getTitle());
    }
}
