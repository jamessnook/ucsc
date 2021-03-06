<?php
/**
 * The base view component file for creating a dlimited a list of words for download.
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.words
 */

$rows = $model->inflections()->getData();
$title = "Inflection List ";
$subTitle = "";
$fileName = "inflections.txt";
//$hideCols = array("wordId", "concrete", "coxStatus");
$hideCols = array();
// use CSV data list but supply tab as alternative delimiter
$content = DelimitedDataList::getDelimitedReport($title, $subTitle, $rows, $hideCols, "\t", $fileName);
// modify col names in first row to make more readable at head of file
foreach($model->attributeLabels() as $name => $label){
    $content = preg_replace("/$name/", $label, $content, 1);
}
$iModel = new InflectedWord;
foreach($iModel->attributeLabels() as $name => $label){
    $content = preg_replace("/$name/", $label, $content, 1);
}
echo $content;

