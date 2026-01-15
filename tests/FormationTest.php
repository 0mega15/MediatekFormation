<?php

use App\Entity\Formation;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationTest
 *
 * @author enzog
 */
class FormationTest extends TestCase
{
    public function testDateParutionString(): void
    {
        $formation = new Formation;
        $formation->setPublishedAt(new DateTime("2024-04-24"));
        $this->assertEquals("24/04/2024", $formation->getPublishedAtString());
    }
    
}
