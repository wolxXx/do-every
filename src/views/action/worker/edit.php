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
 * @var array                     $data
 * @var \DoEveryApp\Entity\Worker $worker
 */
?>
<h1>
    <?= $translator->editWorker(who: \DoEveryApp\Util\View\Worker::get(worker: $worker)) ?>
</h1>

<?= $this->fetchTemplate(template: 'action/worker/partial/addEdit.php', data: ['data' => $data]) ?>