<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/columns'); ?>

<?php $this->beginBlock('title') ?>About<?php $this->endBlock(); ?>

<?php $this->beginBlock('meta'); ?>
    <meta name="description" content="About Page description">
<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs') ?>
	<ul>
		<li><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
		<li class="active">About</li>
	</ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('main') ?>
	<h1>About this site</h1>
<?php $this->endBlock(); ?>
