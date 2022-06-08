<?php

namespace App\Tests\Intagration\Security\Verifier;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group integration
 */
class EmailVerifierTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $userRepo = self::$container->get(UserRepository::class);
        dd($userRepo->findOneBy([]));
    }

    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = self::$container->get('router');
        // $myCustomService = self::$container->get(CustomService::class);
    }
}
