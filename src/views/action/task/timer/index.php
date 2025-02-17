<?php

declare(strict_types=1);

/**
 * @var \Slim\Views\PhpRenderer        $this
 * @var \DoEveryApp\Util\ErrorStore    $errorStore
 * @var string                         $currentRoute
 * @var string                         $currentRoutePattern
 * @var \DoEveryApp\Entity\Worker|null $currentUser
 * @var \DoEveryApp\Util\Translator    $translator
 */
/**
 * @var \DoEveryApp\Entity\Task\Timer[] $timers
 */
?>

<h1>Timer</h1>
<table class="app-table">
    <thead>
    </thead>
    <tbody>
        <? foreach ($timers as $timer): ?>
            <tr>
                <td>
                    <?= $timer->getId() ?>
                </td>
            </tr>
        <? endforeach ?>
    </tbody>
</table>