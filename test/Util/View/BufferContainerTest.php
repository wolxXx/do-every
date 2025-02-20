<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class BufferContainerTest extends \DoEveryAppTest\TestBase
{
    public function testEmpty(): void
    {
        $container = new \DoEveryApp\Util\View\BufferContainer();
        $this->assertSame(expected: '', actual: $container->get());
    }

    public function testSimple(): void
    {
        $container = new \DoEveryApp\Util\View\BufferContainer();
        $counter = $container->next();
        $container->set(registration: 'registration' . $counter, content: 'asdf');
        $counter = $container->next();
        $container->set(registration: 'registration' . $counter, content: 'foobar');
        $this->assertSame(expected: 'asdf foobar', actual: $container->get());
    }

    public function testWithAsyncCall(): void

    {
        $container = new \DoEveryApp\Util\View\BufferContainer();
        \Amp\async(function ($id) use ($container) {
            ob_start();
            usleep(microseconds: rand(1000, 2000));
            echo 'asdf';
            $container->set(registration: $id, content: ob_get_clean());
        }, $container->next());
        \Amp\async(function ($id) use ($container) {
            ob_start();
            usleep(microseconds: rand(400000, 1000000));
            sleep(seconds: rand(2, 5));
            echo 'foobar';
            $container->set(registration: $id, content: ob_get_clean());
        }, $container->next());
        \Amp\async(function ($id) use ($container) {
            ob_start();
            usleep(microseconds: rand(400000, 1000000));
            echo 'lorl rofl';
            $container->set(registration: $id, content: ob_get_clean());
        }, $container->next());
        $this->assertSame(expected: 'asdf foobar lorl rofl', actual: ''.$container);
    }
}