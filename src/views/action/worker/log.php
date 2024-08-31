<?php

/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 */

/**
 * @var $data   \DoEveryApp\Entity\Execution[]
 * @var $worker \DoEveryApp\Entity\Worker
 */

?>
<h1>
    Arbeitsnachweis für Worker "<?= \DoEveryApp\Util\View\Escaper::escape($worker->getName()) ?>"
</h1>

<? if(0 === sizeof($data)): ?>
    - bisher kein Beitrag geleistet -
<? endif ?>
<? if(0 !== sizeof($data)): ?>


    <table>
        <thead>
            <tr>
                <th>
                    Gruppe
                </th>
                <th>
                    Aufgabe
                </th>
                <th>
                    Dauer
                </th>
                <th>
                    Notiz
                </th>
            </tr>
        </thead>
        <tbody>
            <? foreach($data as $execution): ?>
                <tr>
                    <td>
                        <?= \DoEveryApp\Util\View\DateTime::getDateTime($execution->getDate()) ?>
                    </td>
                    <td>
                        <? if(null === $execution->getTask()->getGroup()): ?>
                            -
                        <? endif ?>
                        <? if(null !== $execution->getTask()->getGroup()): ?>
                            <?= \DoEveryApp\Util\View\Escaper::escape($execution->getTask()->getGroup()->getName()) ?>
                        <? endif ?>
                    </td>
                    <td>
                        <?= \DoEveryApp\Util\View\Escaper::escape($execution->getTask()->getName()) ?>
                    </td>
                    <td>
                        <?= \DoEveryApp\Util\View\Duration::byExecution($execution) ?>
                    </td>
                    <td>
                        <?= nl2br(\DoEveryApp\Util\View\Escaper::escape($execution->getNote()) ) ?>
                    </td>
                </tr>
            <? endforeach ?>
        </tbody>
    </table>
<? endif ?>