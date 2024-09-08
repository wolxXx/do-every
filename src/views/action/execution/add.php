<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 */

/**
 * @var $task            \DoEveryApp\Entity\Task
 * @var $data            array
 */

?>


<h1>
    Ausführung hinzufügen
</h1>
<div>
    Aufgabe: <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
    <? if(null !== $task->getGroup()): ?>
        |  Gruppe: <?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>
    <? endif ?>
</div>

<?= $this->fetchTemplate('action/execution/partial/addEdit.php', ['data' => $data]) ?>
