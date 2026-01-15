<?php


namespace App\Test\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author enzog
 */
class PlaylistRepositoryTest extends KernelTestCase
{
    public function recupRepository(): PlaylistRepository
    {
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
    
    private function getEntityManager()
    {
        return self::getContainer()->get('doctrine')->getManager();
    }
    
    public function newPlaylist(): Playlist
    {
        $playlist = (new Playlist())
                ->setName('testplaylist');
        return $playlist;
    }
    
    public function testAjoutPlaylist(): void
    {
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylist = $repository->count([]);
        $repository->add($playlist, true);
        $this->assertEquals($nbPlaylist + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testSuppressionPlaylist(): void
    {
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $nbPlaylist = $repository->count([]);
        $repository->remove($playlist, true);
        $this->assertEquals($nbPlaylist - 1, $repository->count([]), "erreur lors de la suppression"); 
    }
    
    public function testFindAllOrderByName(): void
    {
        $repository = $this->recupRepository();
        $em = $this->getEntityManager();
        
        $playlist1 = (new Playlist())
                ->setName('AAPlaylist');
        $em->persist($playlist1);
        
        $playlist2 = (new Playlist())
                ->setName('ZZPlaylist');
        $em->persist($playlist2);
        $em->flush();
        
        $resultASC = $repository->findAllOrderByName('ASC');
        $this->assertEquals('AAPlaylist', $resultASC[0]->getName());

        $resultDESC = $repository->findAllOrderByName('DESC');
        $this->assertEquals('ZZPlaylist', $resultDESC[0]->getName());
    }
    
    public function testFindAllOrderByFormationNumber(): void
    {
        $repository = $this->recupRepository();
        $em = $this->getEntityManager();
        
        $playlist1 = (new Playlist())
                ->setName('fPlaylistNoFormation');
        $em->persist($playlist1);
        $em->flush();
        
        $resultDESC = $repository->findAllOrderByFormationNumber('DESC');
        $this->assertEquals('Bases de la programmation (C#)', $resultDESC[0]->getName());

        $resultASC = $repository->findAllOrderByFormationNumber('ASC');
        $this->assertEquals('fPlaylistNoFormation', $resultASC[0]->getName());
    }
    
    public function testFindByContainValue(): void
    {
        $repository = $this->recupRepository();
        $em = $this->getEntityManager();
        
        $playlist = (new Playlist())
                ->setName('ValueTestPlaylist');
        $em->persist($playlist);
        $em->flush();
        
        $result = $repository->findByContainValue('name', 'Value');
        $this->assertEquals('ValueTestPlaylist', $result[0]->getName());
    }
}
