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
 * @var string $text
 */
$id = Ramsey\Uuid\Uuid::uuid4();
?>
<button class="addToClipBoard" id="<?= $id ?>">
    <?= \DoEveryApp\Util\View\Icon::copy() ?>
</button>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const copyButton = document.getElementById("<?= $id ?>");
        copyButton.addEventListener("click", (event) => {
            event.stopPropagation();
            event.preventDefault();
            navigator.clipboard.writeText(<?= json_encode($text) ?>);
            console.log(copyButton);
            let style = copyButton.style;
            copyButton.style.border = "2px solid green";
            copyButton.style.background = "green";
            window.setTimeout(() => {
                copyButton.style = style;
            }, 2000);
            return false;
        });
    })

</script>