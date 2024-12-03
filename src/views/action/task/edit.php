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
 * @var array                   $data
 * @var \DoEveryApp\Entity\Task $task
 */
?>
<h1>
    <?= $translator->editTask( '"<a href="'. \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) .'">'. \DoEveryApp\Util\View\Escaper::escape($task->getName()) .'</a>"') ?>
</h1>
<?= $this->fetchTemplate('action/task/partial/addEdit.php', ['data' => $data]) ?>