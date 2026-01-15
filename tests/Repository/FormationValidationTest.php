<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Test\Repository;

use App\Entity\Formation;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of FormationValidationTest
 *
 * @author enzog
 */
class FormationValidationTest extends KernelTestCase 
{
    public function getFormation(): Formation
    {
        return (new Formation())
            ->setTitle('Faire des tests');
    }
    
    public function assertErrors(Formation $formation, int $nbErreursAttendues)
    {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($formation);
        $this->assertCount($nbErreursAttendues, $error);
    }
    
    public function testDateValid()
    {
        $formation = $this->getFormation()->setPublishedAt(new DateTime("2024-04-24"));
        $this->assertErrors($formation, 0);
    }
    
    public function testDateNonValid() 
    {
        $formation = $this->getFormation()->setPublishedAt(new DateTime("2099-12-12"));
        $this->assertErrors($formation, 1);
    }
            
}
