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
?>

<h1>
    Einstellungen bearbeiten
</h1>

<form action="" method="post" novalidate>
    <div>
        <label for="fillTimeLine">
            Zeitlinie auffüllen?
        </label>
        <select name="fillTimeLine" id="fillTimeLine">
            <option <?= array_key_exists('fillTimeLine', $data) && $data['fillTimeLine'] == '1' ? 'selected'  : '' ?>  value="1">
                ja
            </option>
            <option <?=  false === array_key_exists('fillTimeLine', $data) || $data['fillTimeLine'] == '0' ? 'selected'  : '' ?>  value="0">
                nein
            </option>
        </select>
        <div class="errors">
            <? foreach ($errorStore->getErrors('fillTimeLine') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>
    <div>
        <label for="precisionDue">
            Fälligkeitpräzision
        </label>
        <select name="precisionDue" id="precisionDue">
            <? foreach(range(0, 5) as $precision): ?>
                <option <?= array_key_exists('precisionDue', $data) && $data['precisionDue'] == ''.$precision ? 'selected'  : '' ?>  value="<?= $precision ?>">
                    <?= $precision ?>
                </option>
            <? endforeach ?>
        </select>
        <div class="errors">
            <? foreach ($errorStore->getErrors('precisionDue') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>
    <div>
        <label for="keepBackups">
            Backups aufheben (Tage)
        </label>
        <select name="keepBackups" id="keepBackups">
            <? foreach(range(0, 90) as $precision): ?>
                <option <?= array_key_exists('keepBackups', $data) && $data['keepBackups'] == ''.$precision ? 'selected'  : '' ?>  value="<?= $precision ?>">
                    <?= $precision ?>
                </option>
            <? endforeach ?>
        </select>
        <div class="errors">
            <? foreach ($errorStore->getErrors('keepBackups') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div class="app-card-footer">
        <input class="primaryButton" type="submit" value="speichern">
    </div>
</form>