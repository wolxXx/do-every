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

$current = \DoEveryApp\Util\User\Current::getLanguage();
?>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let links = document.querySelectorAll(".languageSwitcher");
        links.forEach(function (link) {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                document.cookie = "lang=" + link.dataset.language;
                if(true === confirm('reload?')) {
                    location.reload();
                }
            });
        });
    });
</script>

<style type="text/css">
    .languageSwitcher {
        filter: opacity(0.4);
        border: solid 1px #999;
        display: inline-block;
        padding: 0;
        margin: 0;
        cursor: pointer;
    }
    .languageSwitcher.active {
        filter: opacity(1);
        border: solid 1px #fff;
    }
    .languageSwitcher svg {
        width: 20px;
        height: 20px;
        padding: 0;
        margin: 0;
    }
</style>

<span class="languageSwitcher <?= 'de' === $current ? 'active': '' ?>" data-language="de">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path fill="#cc2b1d" d="M1 11H31V21H1z"></path><path d="M5,4H27c2.208,0,4,1.792,4,4v4H1v-4c0-2.208,1.792-4,4-4Z"></path><path d="M5,20H27c2.208,0,4,1.792,4,4v4H1v-4c0-2.208,1.792-4,4-4Z" transform="rotate(180 16 24)" fill="#f8d147"></path><path d="M27,4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4Zm3,20c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24Z" opacity=".15"></path><path d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z" fill="#fff" opacity=".2"></path></svg>
</span>

<span class="languageSwitcher <?= 'en' === $current ? 'active': '' ?>" data-language="en">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><rect x="1" y="4" width="30" height="24" rx="4" ry="4" fill="#071b65"></rect><path d="M5.101,4h-.101c-1.981,0-3.615,1.444-3.933,3.334L26.899,28h.101c1.981,0,3.615-1.444,3.933-3.334L5.101,4Z" fill="#fff"></path><path d="M22.25,19h-2.5l9.934,7.947c.387-.353,.704-.777,.929-1.257l-8.363-6.691Z" fill="#b92932"></path><path d="M1.387,6.309l8.363,6.691h2.5L2.316,5.053c-.387,.353-.704,.777-.929,1.257Z" fill="#b92932"></path><path d="M5,28h.101L30.933,7.334c-.318-1.891-1.952-3.334-3.933-3.334h-.101L1.067,24.666c.318,1.891,1.952,3.334,3.933,3.334Z" fill="#fff"></path><rect x="13" y="4" width="6" height="24" fill="#fff"></rect><rect x="1" y="13" width="30" height="6" fill="#fff"></rect><rect x="14" y="4" width="4" height="24" fill="#b92932"></rect><rect x="14" y="1" width="4" height="30" transform="translate(32) rotate(90)" fill="#b92932"></rect><path d="M28.222,4.21l-9.222,7.376v1.414h.75l9.943-7.94c-.419-.384-.918-.671-1.471-.85Z" fill="#b92932"></path><path d="M2.328,26.957c.414,.374,.904,.656,1.447,.832l9.225-7.38v-1.408h-.75L2.328,26.957Z" fill="#b92932"></path><path d="M27,4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4Zm3,20c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24Z" opacity=".15"></path><path d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z" fill="#fff" opacity=".2"></path></svg>
</span>
<? if(true === false): ?>

    <span class="languageSwitcher <?= 'pl' === $current ? 'active': '' ?>"  data-language="pl">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path d="M1,24c0,2.209,1.791,4,4,4H27c2.209,0,4-1.791,4-4V15H1v9Z" fill="#cb2e40"></path><path d="M27,4H5c-2.209,0-4,1.791-4,4v8H31V8c0-2.209-1.791-4-4-4Z" fill="#fff"></path><path d="M5,28H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4ZM2,8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8Z" opacity=".15"></path><path d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z" fill="#fff" opacity=".2"></path></svg>
    </span>

    <span class="languageSwitcher <?= 'fr' === $current ? 'active': '' ?>" data-language="fr">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path fill="#fff" d="M10 4H22V28H10z"></path><path d="M5,4h6V28H5c-2.208,0-4-1.792-4-4V8c0-2.208,1.792-4,4-4Z" fill="#092050"></path><path d="M25,4h6V28h-6c-2.208,0-4-1.792-4-4V8c0-2.208,1.792-4,4-4Z" transform="rotate(180 26 16)" fill="#be2a2c"></path><path d="M27,4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4Zm3,20c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24Z" opacity=".15"></path><path d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z" fill="#fff" opacity=".2"></path></svg>
    </span>
<? endif ?>

<span class="languageSwitcher <?= 'nz' === $current ? 'active': '' ?>"  data-language="nz">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><rect x="1" y="4" width="30" height="24" rx="4" ry="4" fill="#071b65"></rect><path d="M6.5,13.774v2.226h4v-2.227l3.037,2.227h2.463v-1.241l-3.762-2.759h3.762v-4h-2.74l2.74-2.009v-1.991h-1.441l-4.059,2.977v-2.977H6.5v2.794l-3.257-2.389c-.767,.374-1.389,.983-1.786,1.738l2.532,1.858H1s0,0,0,0v4h3.763l-3.763,2.76v1.24H3.464l3.036-2.226Z" fill="#fff"></path><path d="M1.806,5.589l3.285,2.411h1.364L2.36,4.995c-.204,.18-.39,.377-.554,.594Z" fill="#b92831"></path><path fill="#b92831" d="M1 16L6.454 12 6.454 13 2.363 16 1 16z"></path><path fill="#b92831" d="M9.5 16L7.5 16 7.5 11 1 11 1 9 7.5 9 7.5 4 9.5 4 9.5 9 16 9 16 11 9.5 11 9.5 16z"></path><path fill="#b92831" d="M16 15.667L11 12 11 13 15.091 16 16 16 16 15.667z"></path><path fill="#b92831" d="M16 4L15.752 4 10.291 8.004 11.655 8.004 16 4.818 16 4z"></path><path d="M27,4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4Zm3,20c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24Z" opacity=".15"></path><path d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z" fill="#fff" opacity=".2"></path><path fill="#b92831" d="M23.495 8.062L23.008 9.56 21.433 9.56 22.707 10.486 22.22 11.984 23.495 11.058 24.769 11.984 24.282 10.486 25.556 9.56 23.981 9.56 23.495 8.062z"></path><path d="M25.007,12.311l-1.512-1.098-1.512,1.098,.578-1.777-1.512-1.099h1.869l.578-1.777,.578,1.777h1.869l-1.512,1.099,.578,1.777Zm-1.512-1.407l1.037,.752-.396-1.218,1.036-.753h-1.281l-.396-1.219-.396,1.219h-1.281l1.036,.753-.396,1.218,1.037-.752Z" fill="#fff"></path><path fill="#b92831" d="M23.495 19.076L23.008 20.574 21.433 20.574 22.707 21.5 22.22 22.998 23.495 22.072 24.769 22.998 24.282 21.5 25.556 20.574 23.981 20.574 23.495 19.076z"></path><path d="M25.007,23.325l-1.512-1.099-1.512,1.099,.578-1.777-1.512-1.099h1.869l.578-1.777,.578,1.777h1.869l-1.512,1.099,.578,1.777Zm-1.512-1.407l1.037,.753-.396-1.219,1.036-.753h-1.281l-.396-1.219-.396,1.219h-1.281l1.036,.753-.396,1.219,1.037-.753Z" fill="#fff"></path><path fill="#b92831" d="M27.503 12.774L27.111 13.983 25.84 13.983 26.868 14.73 26.475 15.938 27.503 15.191 28.531 15.938 28.139 14.73 29.167 13.983 27.896 13.983 27.503 12.774z"></path><path d="M28.769,16.265l-1.266-.92-1.266,.92,.483-1.488-1.266-.919h1.564l.483-1.488,.483,1.488h1.564l-1.266,.919,.483,1.488Zm-1.266-1.229l.79,.574-.302-.929,.79-.574h-.977l-.302-.929-.302,.929h-.977l.79,.574-.302,.929,.79-.574Z" fill="#fff"></path><path fill="#b92831" d="M19.77 13.417L19.377 14.625 18.106 14.625 19.134 15.372 18.742 16.58 19.77 15.833 20.798 16.58 20.405 15.372 21.433 14.625 20.162 14.625 19.77 13.417z"></path><path d="M21.035,16.907l-1.266-.919-1.266,.919,.483-1.487-1.266-.92h1.564l.483-1.488,.483,1.488h1.565l-1.266,.92,.483,1.487Zm-1.266-1.228l.79,.574-.302-.929,.791-.574h-.977l-.302-.929-.302,.929h-.977l.79,.574-.302,.929,.79-.574Z" fill="#fff"></path></svg>
</span>

