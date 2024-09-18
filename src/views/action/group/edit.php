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
 * @var array                    $data
 * @var \DoEveryApp\Entity\Group $group
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

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->go() ?>">
    </div>

</form>
