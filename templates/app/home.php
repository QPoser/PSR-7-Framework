<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/columns'); ?>

<?php $this->beginBlock('title') ?>Home<?php $this->endBlock(); ?>

<?php $this->beginBlock('meta'); ?>
	<meta name="description" content="Home page description">
<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs') ?>
	<ul class="breadcrumb">
		<li class="active">Home</li>
	</ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('main') ?>
	<h1>Home page</h1>
<?php $this->endBlock(); ?>