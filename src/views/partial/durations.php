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
 * @var $durations \DoEveryApp\Definition\Durations
 */
?>
<fieldset>
    <legend>
        Statistik
    </legend>

    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    <nobr>Aufwand durchschnittlich:</nobr>
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getAverage()) ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <div class="column">
                    insgesamt:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getTotal()) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    heute:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getDay()) ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <div class="column">
                    gestern:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getLastDay()) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    diese Woche:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getWeek()) ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <div class="column">
                    letzte Woche:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getLastWeek()) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    dieser Monat:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getMonth()) ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <div class="column">
                    letzter Monat:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getLastMonth()) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    dieses Jahr:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getYear()) ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <div class="column">
                    letztes Jahr:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getLastYear()) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <h3>Nach Monaten</h3>
            <? foreach($durations->getMonths() as $month => $duration): ?>
                <div class="row">
                    <div class="column">
                        <?= $month ?>:
                    </div>
                    <div class="column">
                        <?= \DoEveryApp\Util\View\Duration::byValue($duration) ?>
                    </div>
                </div>
            <? endforeach ?>
        </div>
        <div class="column">
            <h3>Nach Jahren</h3>
            <? foreach($durations->getYears() as $year => $duration): ?>
                <div class="row">
                    <div class="column">
                        <?= $year ?>:
                    </div>
                    <div class="column">
                        <?= \DoEveryApp\Util\View\Duration::byValue($duration) ?>
                    </div>
                </div>
            <? endforeach ?>
        </div>
    </div>
</fieldset>