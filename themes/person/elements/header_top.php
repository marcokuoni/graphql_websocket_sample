<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>
<!DOCTYPE HTML>
<html lang="<?php echo Localization::activeLanguage() ?>">
<head>
    <base href="/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php Loader::element('header_required'); ?>
    <?php echo $html->css($view->getStylesheet('main.less')) ?>
</head>
<body id="page<?php echo $c->getCollectionID(); ?>">
    <div class="<?php echo $c->getPageWrapperClass() ?>">