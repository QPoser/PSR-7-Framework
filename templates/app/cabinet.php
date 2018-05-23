<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/columns'); ?>

<?php $this->beginBlock('title') ?>Cabinet<?php $this->endBlock(); ?>

<?php $this->beginBlock('meta'); ?>
	<meta name="description" content="Cabinet page description">
<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs') ?>
	<ul class="breadcrumb">
		<li><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
		<li class="active">Cabinet</li>
	</ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('main') ?>
	<h1>Hello, <?=$username?></h1>
<?php $this->endBlock(); ?>