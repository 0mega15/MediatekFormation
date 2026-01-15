<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of FormationControllerTest
 *
 * @author enzog
 */
class FormationControllerTest extends WebTestCase
{
    public function testFiltreFormation()
    {
        $client = static::createClient();
        $client->request('GET', '/formations');
        
        $crawler = $client->submitForm('filtrer_formation', [
            'recherche' => 'C# : ListBox'
        ]);
        
        $this->assertCount(1, $crawler->filter('h5'));
        
        $this->assertSelectorTextContains('h5', 'C# : ListBox en couleur');
    }
    
    public function testFiltrePlaylist()
    {
        $client = static::createClient();
        $client->request('GET', '/formations');
        
        $crawler = $client->submitForm('filtrer_playlist', [
            'recherche' => 'Cours UML'
        ]);
        
        $this->assertCount(10, $crawler->filter('.playlist-name'));
        
        $this->assertSelectorTextContains('.playlist-name', 'Cours UML');
    }
    
    public function testTriFormation() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations');
        
        $link = $crawler->filter('a[name="ASC_formation"]')->link();
        $crawler = $client->click($link);
        
        $this->assertSelectorTextContains('h5', 'Android Studio (complément n°1) : Navigation Drawer et Fragment');
        
        $link = $crawler->filter('a[name="DESC_formation"]')->link();
        $crawler = $client->click($link);
        
        $this->assertSelectorTextContains('h5', 'UML : Diagramme de paquetages');
    }
    
    public function testTriPlaylist() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations');
        
        $link = $crawler->filter('a[name="ASC_playlist"]')->link();
        $crawler = $client->click($link);
        
        $this->assertSelectorTextContains('.playlist-name', 'Bases de la programmation (C#)');
        
        $link = $crawler->filter('a[name="DESC_playlist"]')->link();
        $crawler = $client->click($link);
        
        $this->assertSelectorTextContains('.playlist-name', 'Visual Studio 2019 et C#');
    }
    
    public function testTriDate() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations');
        
        $link = $crawler->filter('a[name="ASC_date"]')->link();
        $crawler = $client->click($link);
        
        $this->assertSelectorTextContains('.date-parution', '25/09/2016');
        
        $link = $crawler->filter('a[name="DESC_date"]')->link();
        $crawler = $client->click($link);
        
        $this->assertSelectorTextContains('.date-parution', '04/01/2021');
    }
    
}
