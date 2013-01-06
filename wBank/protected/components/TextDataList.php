<?php

/***************************************************************************
*                        Copyright (c) 2012                                *
*              James E Snook, Kelly Stack &  Judith Scott                  *
*                                                                          *
*                       Education Departmetn                               *
*                                                                          *
*                 University of California, Santa Cruz                     *
*                                                                          *
*                       All Rights Reserved.                               *
*                                                                          *
*                                                                          *
*  Redistribution and use in source and binary forms, with or without      *
*  modification, are permitted provided that the following conditions      *
*  are met:                                                                *
*                                                                          *
*  Redistributions of source code must retain the above copyright          *
*    notice, this list of conditions and the following disclaimer.         *
*                                                                          *
*                                                                          *
*  Redistributions in binary form must reproduce the above copyright       *
*    notice, this list of conditions and the following disclaimer in       *
*    the documentation and/or other materials provided with the            *
*    distribution.                                                         *
*                                                                          *
*                                                                          *
***************************************************************************/

/**
 * Action Data List Element in text format for file downloads
 *
 * Formats a list of data rows (a table) in readable text format for output to a file.
 * The passed in set of data rows is usually generated using a query.
 * Assumes the passed in row set $rows has a column named Id.
 * @author Jim Snook <jsnook@soe.ucsc.edu>
 *
 */
class TextDataList {
    protected $text = ""; 			///< string for output
	
    /**
     * Constructor
     * @param   $title Title string for this action list.
     * @param   $subTitle Additional Title string for this data list, goesafter the first one.
     * @param   $rows Array of data rows to populate table with.
     * @param   $hideCols Array of names of collumns in row set to not display.
     */
	function __construct($title = "", $subTitle = "", $rows=null, $hideCols = array()) {
		header("Cache-control: private");
		//header("'Content-type: application/octet-stream");
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="report.txt"'); 
		if (strlen($title) > 0){
			$this->text .= $title . "\n";
        }
        if (strlen($subTitle) > 0){
			$this->text .= $subTitle . "\n";
        }
        if (strlen($this->text) > 0){
        	$this->text .= "\n";
        }
        
        // For now do a table version
        $i = 0;
        if ($rows){
			$colWidth[]= array();
			// walk all data to calulate maximum column with
            foreach($rows as $row){
			    foreach( $row as $colName => $value){
					if (!in_array($colName, $hideCols)){ 
			    	//if (!isset($hideCols[$colName])){
						if ($i == 0){
							$colWidth[$colName] = strlen($value);
						}
						else if (strlen($value) > $colWidth[$colName]){
							$colWidth[$colName] = strlen($value);
						}
					}
			    }
			    $i++;
			}
			$i = 0;
            foreach($rows as $row){
			    if ($i == 0){
					foreach( $row as $colName => $value){
						if (!in_array($colName, $hideCols)){ 
							$colWidth[$colName] += 2; 
							$this->text .= str_pad($colName . " ", $colWidth[$colName]);
						}
					}
					$this->text .= "\n\n";
			    }
			    foreach( $row as $colName => $value){
					if (!in_array($colName, $hideCols)){ 
			    		$this->text .= str_pad($value, $colWidth[$colName]);
					}
			    }
				$this->text .= "\n";
			    $i++;
			}
		}
    }

	
	
    /**
     * Getter method
     * @return the text report
     */
	public function getText() {
		return $this->text;
	}
    	
	
    /**
     * build method
     * @param   text string to add to teh report.
     */
	public function addText($str) {
		$this->text .= $str;
	}
    	
	
	/**
     * Convenience method
     * @param   $title Title string for this action list.
     * @param   $subTitle Additional Title string for this data list, goesafter tehfirst one.
     * @param   $rows Array of data rows to populate table with.
     * @param   $hideCols Array of names of collumns in row set to not display.
     * @return the text report
     */
	static function getTextReport($title="", $subTitle = "", $rows=null, $hideCols = array()) {
		$report = new TextDataList($title, $subTitle, $rows, $hideCols);
		
		return $report->getText();
	}
}

