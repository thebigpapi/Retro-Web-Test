<?php

namespace App\Test\Entity;

use App\Entity\User;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase 
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->databaseTool = self::$container->get(DatabaseToolCollection::class)->get();
    }

    public function getEntity(): User {
        return (new User())
        ->setUsername("Deksor")
        ->setPassword("rgejhnuheehuee");
    }

    public function getValidator():ValidatorInterface {
        /*return Validation::createValidatorBuilder()
        ->enableAnnotationMapping(true)
        ->addDefaultDoctrineAnnotationReader()
        ->getValidator();*/
        return self::$container->get("validator");
    }

    public function assertHasErrors(User $user, int $number = 0) {
        $validator = $this->getValidator();
        $errors = $validator->validate($user);

        $messages = [];
        /**
         * @var ConstraintViolation $error
         */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ": " . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(", ", $messages));
    }

    public function testValidEntity() {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidEntity() {
        $this->assertHasErrors($this->getEntity()->setUsername("a"), 1);
        $this->assertHasErrors($this->getEntity()->setUsername(""), 2);
        $this->assertHasErrors($this->getEntity()->setUsername("roighjrtjreioujhiuoeriohreiojherhjoierohirohejiojzejfjejzjezje"), 1);
        $this->assertHasErrors($this->getEntity()->setPassword("1234"), 1);
        $this->assertHasErrors($this->getEntity()->setPassword(""), 1);
        $this->assertHasErrors(new User(), 2);
    }

    public function testInvalidUsedUser() {
        $this->databaseTool->loadAliceFixture([
            dirname(__DIR__) . "/fixtures/users.yaml",
        ]);
        $this->assertHasErrors($this->getEntity()->setUsername("Big Monstro"), 1);
    }
}