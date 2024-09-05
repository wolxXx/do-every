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
 * @var $data array
 * @var $worker \DoEveryApp\Entity\Worker
 */

?>
<h1>
    Worker "<?= \DoEveryApp\Util\View\Worker::get($worker) ?>" bearbeiten
</h1>

<?= $this->fetchTemplate('action/worker/partial/addEdit.php', ['data' => $data]) ?>