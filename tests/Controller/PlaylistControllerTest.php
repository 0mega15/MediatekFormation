<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistControllerTest
 *
 * @author enzog
 */
class PlaylistControllerTest extends WebTestCase {
    
    public function testFiltrePlaylist()
    {
        $client = static::createClient();
        $client->request('GET', '/playlists');
        
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Bases de la programmation (C#)'
        ]);
        
        $this->assertCount(1, $crawler->filter('h5'));
        
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
    }
    
    public function testTriPlaylist() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists');
        
        $link = $crawler->filter('a[name="ASC_playlist"]')->link();
        $crawler = $client->click($link);
        
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
        
        $link = $crawler->filter('a[name="DESC_playlist"]')->link();
        $crawler = $client->click($link);
        
        $this->assertSelectorTextContains('h5', 'Visual Studio 2019 et C#');
    }
    
    public function testTriNbFormation() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists');
        
        $link = $crawler->filter('a[name="ASC_nbFormation"]')->link();
        $crawler = $client->click($link);
        
        $this->assertSelectorTextContains('.nbFormation', '1');
        
        $link = $crawler->filter('a[name="DESC_nbFormation"]')->link();
        $crawler = $client->click($link);
        
        $this->assertSelectorTextContains('.nbFormation', '74');
    }
    
    public function testLinkPlaylist()
    {
        $client = static::createClient();
        $client->request('GET', '/playlists');
        
        $client->clickLink('Voir détail');
                 
        $response = $client->getResponse();
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/playlists/playlist/13', $uri);          
    }
}
