<?php

/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 */

/**
 * @var $data array
 * @var $group \DoEveryApp\Entity\Group
 */

?>
<h1>
    Gruppe "<?= \DoEveryApp\Util\View\Escaper::escape($group->getName()) ?>" bearbeiten
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="name">
            Name
        </label>
        <input id="name" type="text" name="name" value="<?= array_key_exists('name', $data) ? $data['name'] : '' ?>"/>
        <div class="errors">
            <? foreach ($errorStore->getErrors('name') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div>
        <label for="color">
            Farbe
        </label>
        <input id="color" type="color" name="color" value="<?= array_key_exists('color', $data) ? $data['color'] : '' ?>"/>
        <div class="errors">
            <? foreach ($errorStore->getErrors('color') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div class="app-card-footer">
        <input class="primaryButton" type="submit" value="los">
    </div>

</form>