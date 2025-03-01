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
 * @var \DoEveryApp\Entity\Execution | null $execution
 * @var \DoEveryApp\Entity\Task             $task
 * @var array                               $data
 */
?>

<h1>
    <?php if (null === $execution): ?>
        <?= $translator->addExecution() ?>
    <?php endif ?>
    <?php if (null !== $execution): ?>
        <?= $translator->editExecution() ?>
    <?php endif ?>
</h1>
<fieldset>
    <legend><?= $translator->timer() ?></legend>


<div style="margin: 10px 0; padding: 10px;" id="timerArea">
</div>
<div>
    <button id="startTimer" class="primaryButton">
        <?= $translator->timerStart() ?>
    </button>
    <button id="pauseTimer" class="primaryButton">
        <?= $translator->timerPause() ?>
    </button>
    <button id="stopTimer" class="primaryButton">
        <?= $translator->timerStop() ?>
    </button>
    <button id="resetTimer" class="primaryButton">
        <?= $translator->timerReset() ?>
    </button>
    <button id="takeTime" class="primaryButton">
        <?= $translator->timerTakeTime() ?>
    </button>
</div>
</fieldset>
<script>
    const timeOut = 5000;
    let info = null;
    let interval = null;

    function showStartButton() {
        document.querySelector('#startTimer').style.display = 'inline-block'
    }
    function hideStartButton() {
        document.querySelector('#startTimer').style.display = 'none'
    }

    function showPauseButton() {
        document.querySelector('#pauseTimer').style.display = 'inline-block'
    }
    function hidePauseButton() {
        document.querySelector('#pauseTimer').style.display = 'none'
    }

    function showStopButton() {
        document.querySelector('#stopTimer').style.display = 'inline-block'
    }
    function hideStopButton() {
        document.querySelector('#stopTimer').style.display = 'none'
    }

    function showResetButton() {
        document.querySelector('#resetTimer').style.display = 'inline-block'
    }
    function hideResetButton() {
        document.querySelector('#resetTimer').style.display = 'none'
    }

    function showTakeButton() {
        document.querySelector('#takeTime').style.display = 'inline-block'
    }
    function hideTakeButton() {
        document.querySelector('#takeTime').style.display = 'none'
    }

    function showStatus() {
        hideStartButton()
        hidePauseButton()
        hideStopButton()
        hideResetButton()
        hideTakeButton()
        const timerAreaElement = document.querySelector('#timerArea');
        if (null === info) {
            timerAreaElement.innerHTML = '??';
            showStartButton()
            hidePauseButton()
            hideStopButton()
            hideResetButton()
            hideTakeButton()
            return
        }

        timerAreaElement.innerHTML = '<span id="now">now: ' + moment(info.now).format("dddd, MMMM Do YYYY, h:mm:ss a") +'</span>'
        console.log(moment(info.now).format("dddd, MMMM Do YYYY, h:mm:ss a"))
        clearInterval(interval)
        interval = setInterval(function () {
            document.querySelector('#now').innerHTML = 'now: ' + moment().format("dddd, MMMM Do YYYY, h:mm:ss a")
        }, 200)

        if (true === info.running) {
            hideStartButton()
            showPauseButton()
            showStopButton()
            showResetButton()
            showTakeButton()
            timerAreaElement.innerHTML += '<br>running timer ' + info.minutes + ' min, ' + info.seconds + ' seconds'
            return;
        }
        if (true === info.paused) {
            showStartButton()
            hidePauseButton()
            showStopButton()
            showResetButton()
            showTakeButton()
            timerAreaElement.innerHTML += '<br>paused timer ' + info.minutes + ' min, ' + info.seconds + ' seconds'
            return;
        }

        showResetButton()
        showStartButton()
        if(null === info.last) {
            hideTakeButton()
        }
        if(null !== info.last) {
            timerAreaElement.innerHTML += '<br>last time: ' + info.last + ' min'
            showTakeButton()
        }


    }
    function fetchStatus(fetchNew = true) {
        fetch('<?= \DoEveryApp\Action\Task\Timer\StatusAction::getRoute(id: $task->getId()) ?>', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    if(fetchNew) {
                        setTimeout(fetchStatus, timeOut);
                    }
                    info = null
                    showStatus()
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                if(fetchNew) {
                    setTimeout(fetchStatus, timeOut);
                }
                return response.json();
            })
            .then(data => {
                info = data;
                showStatus()
                console.log('Data fetched successfully:', data);
                // Perform actions with the fetched data here
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }
    document.addEventListener('DOMContentLoaded', function () {
        moment.locale('de')
        document.querySelector('#startTimer').addEventListener('click', function (event) {
            event.stopPropagation()
            event.preventDefault()

            fetch('<?= \DoEveryApp\Action\Task\Timer\RunAction::getRoute(id: $task->getId()) ?>', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(()=>{
                fetchStatus(false)
            })
            return false
        })
        document.querySelector('#pauseTimer').addEventListener('click', function (event) {
            event.stopPropagation()
            event.preventDefault()

            fetch('<?= \DoEveryApp\Action\Task\Timer\PauseAction::getRoute(id: $task->getId()) ?>', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(()=>{
                fetchStatus(false)
            })
            return false
        })
        document.querySelector('#stopTimer').addEventListener('click', function (event) {
            event.stopPropagation()
            event.preventDefault()

            fetch('<?= \DoEveryApp\Action\Task\Timer\StopAction::getRoute(id: $task->getId()) ?>', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(()=>{
                fetchStatus(false)
            })
            return false
        })
        document.querySelector('#resetTimer').addEventListener('click', function (event) {
            event.stopPropagation()
            event.preventDefault()

            fetch('<?= \DoEveryApp\Action\Task\Timer\ResetAction::getRoute(id: $task->getId()) ?>', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(()=>{
                fetchStatus(false)
            })
            return false
        })
        document.querySelector('#takeTime').addEventListener('click', function (event) {
            event.stopPropagation()
            event.preventDefault()

            console.log(info.last)
            document.querySelector('#duration').value = info.last
            return false
        })
        fetchStatus()
    });
</script>

<div>
    <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()) ?>">
        <?= $translator->task() ?>: <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getName()) ?>
    </a>
    <?php if (null !== $task->getGroup()): ?>
        |  <?= $translator->group() ?>:
        <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute(id: $task->getGroup()->getId()) ?>">
            <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getGroup()->getName()) ?>
        </a>
    <?php endif ?>
    <hr />
</div>

<?php if (null !== $task->getNote()): ?>
    <div>
        <?= \DoEveryApp\Util\View\TaskNote::byTask(task: $task) ?>
    </div>
<?php endif ?>

<form action="" method="post" novalidate>
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    <div>
                        <label for="worker">
                            <?= $translator->worker() ?>
                        </label>
                        <select name="worker" id="worker">
                            <option <?= false === array_key_exists(key: 'worker', array: $data) || null === $data['worker'] ? 'selected' : '' ?>  value="">
                                - <?= $translator->nobody() ?> -
                            </option>
                            <?php foreach (\DoEveryApp\Entity\Worker::getRepository()->findIndexed() as $worker): ?>
                                <option <?= array_key_exists(key: 'worker', array: $data) && $data['worker'] == $worker->getId() ? 'selected' : '' ?> value="<?= $worker->getId() ?>">
                                    <?= \DoEveryApp\Util\View\Worker::get(worker: $worker) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: 'worker')]) ?>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <label for="date" class="required">
                            Datum
                        </label>
                        <input type="datetime-local" id="date" name="date" value="<?= array_key_exists(key: 'date', array: $data) ? $data['date'] : '' ?>"/>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <label for="duration">
                            Dauer
                        </label>
                        <input type="number" id="duration" name="duration" value="<?= array_key_exists(key: 'duration', array: $data) ? $data['duration'] : '' ?>"/>
                        Minuten
                    </div>
                </div>
            </div>




            <?php if (0 !== count(value: $data['checkListItems'])): ?>
                <hr>
                <table>
                    <thead>
                        <tr>
                            <th>
                                Schritt
                            </th>
                            <th>
                                erledigt?
                            </th>
                            <th>
                                Hinweis
                            </th>
                            <th>
                                Notiz
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['checkListItems'] as $index =>  $checkListItem): ?>
                            <tr>
                                <td>
                                    <?= \DoEveryApp\Util\View\Escaper::escape(value: $checkListItem['name']) ?>
                                    <input type="hidden" readonly checked name="checkListItems[<?= $index ?>][checked]" value="0">
                                    <input type="hidden" readonly checked name="checkListItems[<?= $index ?>][reference]" value="<?= $checkListItem['reference'] ?>">
                                    <input type="hidden" readonly checked name="checkListItems[<?= $index ?>][id]" value="<?= $checkListItem['id'] ?>">
                                </td>
                                <td>
                                    <input type="checkbox" <?= '1' === $checkListItem['checked'] ? 'checked' : '' ?> name="checkListItems[<?= $index ?>][checked]" value="1">
                                </td>
                                <td>
                                    <?= \DoEveryApp\Util\View\CheckListItemNote::byValue(note: $checkListItem['referenceNote']) ?>
                                </td>
                                <td>
                                    <textarea rows="1000" cols="1000" name="checkListItems[<?= $index ?>][note]"><?= $checkListItem['note'] ?></textarea>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <??>
            <?php endif ?>
        </div>
        <div class="column">

            <div>
                <label for="note">
                    Notiz
                </label>
                <textarea name="note" id="note" rows="10000" cols="10000"><?= array_key_exists(key: 'note', array: $data) ? $data['note'] : '' ?></textarea>
            </div>
        </div>
    </div>

    <div>
        <?php if (null === $execution): ?>
            <input class="primaryButton" type="submit" value="<?= $translator->add() ?>" />
        <?php endif ?>
        <?php if (null !== $execution): ?>
            <input class="primaryButton" type="submit" value="<?= $translator->save() ?>" />
        <?php endif ?>

    </div>
</form>