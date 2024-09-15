<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 * @var $translator          \DoEveryApp\Util\Translator
 */


/**
 * @var $data array
 * @var $task \DoEveryApp\Entity\Task
 */
?>
<h1>
    Aufgabe "<a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>"><?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?></a>" bearbeiten
</h1>
<?= $this->fetchTemplate('action/task/partial/addEdit.php', ['data' => $data]) ?>