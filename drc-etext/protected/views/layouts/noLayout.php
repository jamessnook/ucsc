<?php
/**
 * The top level layout file for all views.
 * This is non configurable because of how hte Yii classes use it,
 * (You can pass it a model but no other options.)
 * so it is left empty and _main.php is used instead.
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.layout
 */
?>

<?php $this->beginContent('//layouts/main'); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>