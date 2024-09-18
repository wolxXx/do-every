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
 * @var array $data
 */
?>

<form action="" method="post" novalidate>
    <div class="row">
        <div class="column">
            <div>
                <label for="name">
                    <?= $translator->name() ?>
                </label>
                <input id="name" type="text" name="name" value="<?= array_key_exists('name', $data) ? $data['name'] : '' ?>"/>
                <div class="errors">
                    <? foreach ($errorStore->getErrors('name') as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div>
                <label for="email">
                    <?= $translator->eMail() ?>
                </label>
                <input id="email" type="email" name="email" value="<?= array_key_exists('email', $data) ? $data['email'] : '' ?>"/>
                <div class="errors">
                    <? foreach ($errorStore->getErrors('email') as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div>
                <label for="password">
                    <?= $translator->password() ?>
                </label>
                <input id="password" type="password" name="password" value="<?= array_key_exists('password', $data) ? $data['password'] : '' ?>"/>
                <div class="errors">
                    <? foreach ($errorStore->getErrors('password') as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <div>
                <label for="is_admin">
                    <?= $translator->isAdminQuestion() ?>
                </label>
                <select name="is_admin" id="is_admin">
                    <option <?= array_key_exists('is_admin', $data) && $data['is_admin'] == '1' ? 'selected'  : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?=  false === array_key_exists('is_admin', $data) || $data['is_admin'] == '0' ? 'selected'  : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <div class="errors">
                    <? foreach ($errorStore->getErrors('is_admin') as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div>
                <label for="do_notify_logins">
                    <?= $translator->doNotifyLoginsQuestion() ?>
                </label>
                <select name="do_notify_logins" id="do_notify_logins">
                    <option <?= array_key_exists('do_notify_logins', $data) && $data['do_notify_logins'] == '1' ? 'selected'  : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?= false === array_key_exists('do_notify_logins', $data) || $data['do_notify_logins'] == '0' ? 'selected'  : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <div class="errors">
                    <? foreach ($errorStore->getErrors('do_notify_logins') as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div>
                <label for="do_notify">
                    <?= $translator->doNotifyDueTasksQuestion() ?>
                </label>
                <select name="do_notify" id="do_notify">
                    <option <?= array_key_exists('do_notify', $data) && $data['do_notify'] == '1' ? 'selected'  : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?= false === array_key_exists('do_notify', $data) || $data['do_notify'] == '0' ? 'selected'  : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <div class="errors">
                    <? foreach ($errorStore->getErrors('do_notify') as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->go() ?>">
    </div>
</form>

