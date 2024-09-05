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
 */
$groups = \DoEveryApp\Entity\Group::getRepository()->findIndexed();

?>
<h1>
    neue Aufgabe erstellen
</h1>
<?= $this->fetchTemplate('action/task/partial/addEdit.php', ['data' => $data]) ?>