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
 * @var $durations \DoEveryApp\Definition\Durations
 */
?>
<fieldset>
    <legend>
        <?= $translator->statistics() ?>
    </legend>

    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    <nobr><?= $translator->averageEffort() ?>:</nobr>
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getAverage()) ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <div class="column">
                    <?= $translator->totalEffort() ?>:
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
                    <?= $translator->today() ?>:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getDay()) ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <div class="column">
                    <?= $translator->yesterday() ?>:
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
                    <?= $translator->thisWeek() ?>:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getWeek()) ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <div class="column">
                    <?= $translator->lastWeek() ?>:
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
                    <?= $translator->thisMonth() ?>:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getMonth()) ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <div class="column">
                    <?= $translator->lastMonth() ?>:
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
                    <?= $translator->thisYear() ?>:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getYear()) ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="row">
                <div class="column">
                    <?= $translator->lastYear() ?>:
                </div>
                <div class="column">
                    <?= \DoEveryApp\Util\View\Duration::byValue($durations->getLastYear()) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <h3>
                <?= $translator->byMonth() ?>
            </h3>
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
            <h3>
                <?= $translator->byYear() ?>
            </h3>
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