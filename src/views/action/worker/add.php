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
 */

?>
<h1>
    <?= $translator->addWorker() ?>
</h1>

<?= $this->fetchTemplate('action/worker/partial/addEdit.php', ['data' => $data]) ?>