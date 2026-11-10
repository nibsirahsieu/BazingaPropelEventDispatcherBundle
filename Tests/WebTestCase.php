<?php

namespace Bazinga\Bundle\PropelEventDispatcherBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class WebTestCase extends BaseWebTestCase
{
    protected function deleteTmpDir()
    {
        if (!file_exists($dir = sys_get_temp_dir().'/'.Kernel::VERSION)) {
            return;
        }

        $fs = new Filesystem();
        $fs->remove($dir);
    }

    protected static function getKernelClass(): string
    {
        require_once __DIR__.'/Fixtures/app/AppKernel.php';

        return 'Bazinga\Bundle\PropelEventDispatcherBundle\Tests\Functional\AppKernel';
    }

    protected static function createKernel(array $options = array()): KernelInterface
    {
        $class = self::getKernelClass();

        return new $class(
            'default',
            isset($options['debug']) ? $options['debug'] : true
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->deleteTmpDir();
        static::bootKernel();
    }
}
