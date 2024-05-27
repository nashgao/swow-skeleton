<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Listener;

use Hyperf\Engine\Channel;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\AfterWorkerStart;
use Hyperf\Engine\Coroutine;
use Hyperf\Server\Event\MainCoroutineServerStart;


#[Listener]
class MemoryListener implements ListenerInterface
{

    public function listen(): array
    {
        return [
            AfterWorkerStart::class,
            MainCoroutineServerStart::class
        ];
    }

    /**
     * @param AfterWorkerStart $event
     */
    public function process(object $event): void
    {
        for ($i=0;$i<1000;$i++) {
            Coroutine::create(
                function () {
                    $chan = new Channel();
                    while (true) {
                        $chan->pop();
                    }
                }
            );
        }

    }
}
