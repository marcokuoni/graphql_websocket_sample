<?php
defined('C5_EXECUTE') or die(_('Access Denied.'));
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">

<div id="person"></div>

<script>
    window.onload = function() {
        window.person.configModule({
            showDebugInfos: true,
            productivMode: false,
            secureProtocol: '<?= $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? true : false ?>',
            graphqlUrl: '<?= $_SERVER['HTTP_HOST'] . '/index.php/graphql' ?>',
            websocketUrl: '<?= $_SERVER['HTTP_HOST'] . '/wss2/' ?>',
        });
        window.person.initModule();

        const appStarted = new CustomEvent('appStarted');
        window.dispatchEvent(appStarted);
    };
</script>