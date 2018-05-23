<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/columns');?>

<?php $this->beginBlock('title') ?>Blog<?php $this->endBlock(); ?>

<?php $this->beginBlock('meta'); ?>
	<meta name="description" content="Blog page description">
<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs') ?>
	<ul class="breadcrumb">
		<li><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
		<li class="active">Blog</li>
	</ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('main') ?>
	<h1>This is blog</h1>
	<?= $id ? '<article>Article #' . $id . '</article>' : '' ?>
<?php $this->endBlock(); ?>