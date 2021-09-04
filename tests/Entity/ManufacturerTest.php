<?php

namespace App\Test\Entity;

use App\Entity\Manufacturer;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ManufacturerTest extends KernelTestCase 
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->databaseTool = self::$container->get(DatabaseToolCollection::class)->get();
    }

    public function getEntity(): Manufacturer {
        return (new Manufacturer())
        ->setName("PCChips Inc.")
        ->setShortName("PCChips");
    }

    public function getValidator():ValidatorInterface {
        /*return Validation::createValidatorBuilder()
        ->enableAnnotationMapping(true)
        ->addDefaultDoctrineAnnotationReader()
        ->getValidator();*/
        return self::$container->get("validator");
    }

    public function assertHasErrors(Manufacturer $manufacturer, int $number = 0) {
        $validator = $this->getValidator();
        $error = $validator->validate($manufacturer);
        $this->assertCount($number, $error);
    }

    public function testValidEntity() {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidEntity() {
        $this->assertHasErrors($this->getEntity()->setName(""), 1);
        $this->assertHasErrors(new Manufacturer(), 1);
    }

    public function testInvalidUsedManufacturer() {
        $this->databaseTool->loadAliceFixture([
            dirname(__DIR__) . "/fixtures/manufacturers.yaml",
        ]);
        $this->assertHasErrors($this->getEntity()->setName("ABit Inc.")->setShortName("ABit"), 1);
    }
}