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
 * @var \DoEveryApp\Entity\Execution | null $execution
 * @var \DoEveryApp\Entity\Task             $task
 * @var array                               $data
 */
?>

<?= $this->fetchTemplate('action/execution/partial/addEdit.php', ['data' => $data, 'task' => $task, 'execution' => $execution]) ?>