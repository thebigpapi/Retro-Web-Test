<?php

namespace App\Test\Entity;

use App\Entity\MaxRam;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MaxRamTest extends KernelTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->databaseTool = self::$container->get(DatabaseToolCollection::class)->get();
    }

    public function getEntity(): MaxRam
    {
        return (new MaxRam())
            ->setValue(1024);
    }

    public function getValidator(): ValidatorInterface
    {
        /*return Validation::createValidatorBuilder()
        ->enableAnnotationMapping(true)
        ->addDefaultDoctrineAnnotationReader()
        ->getValidator();*/
        return self::$container->get("validator");
    }

    public function assertHasErrors(MaxRam $maxRam, int $number = 0)
    {
        $validator = $this->getValidator();
        $error = $validator->validate($maxRam);
        $this->assertCount($number, $error);
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setValue(-100), 1);
        $this->assertHasErrors(new MaxRam(), 1);
    }

    public function testInvalidUsedMaxRam()
    {
        $this->databaseTool->loadAliceFixture([
            dirname(__DIR__) . "/fixtures/maxrams.yaml",
        ]);
        $this->assertHasErrors($this->getEntity()->setValue(2048), 1);
    }
}
