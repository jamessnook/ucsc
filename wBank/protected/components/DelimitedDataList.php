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
 * Action Data List Element in CSV format
 * 
 * Creates a component element that consists of a list of data rows from a query (a table).
 * For example a list of classes to edit.
 * The passed in set of data rows is usually generated using a query.
 * Assumes the passed in row set $rows has a column named Id.
 * @author Jim Snook <jsnook@soe.ucsc.edu>
 *
 */
class DelimitedDataList  extends TextDataList {

    /** 
     * Constructor
     * @param   $rows, Array of data rows to populate table with.
     * @param   $subTitle, Additional Title string for this data list, goesafter the first one.
     * @param   $title, Title string for this action list.
     * @param   $hideCols, names of columns in rows not to include in the output.
     * @param   $delimiter, optional alternative delimiter instead of comma.
     */
    function __construct($title = "", $subTitle = "", $rows, $hideCols = array(), $delimiter = ", ", $fileName="wordList.txt") {
        parent::__construct();

		header('Content-Disposition: attachment; filename="' . $fileName . '"'); 
        // For now do a table version
        $i = 0;
        if ($rows){
        	foreach($rows as $row){
        		if ($i == 0){
					foreach( $row as $colName => $value){
						if (!in_array($colName, $hideCols)){ 
						//if (!isset($hideCols[$colName])){
							$this->text .= trim($colName) . $delimiter;
						}
					}
					$this->text .= "\r\n\n";
			    }
			    foreach( $row as $colName => $value){
					if (!in_array($colName, $hideCols)){ 
			    		$this->text .= trim($value) . $delimiter;
					}
			    }
				$this->text .= "\r\n";
			    $i++;
			}
		}
    }

	/**
     * Convenience method
     * @param   $title Title string for this action list.
     * @param   $subTitle Additional Title string for this data list, goesafter tehfirst one.
     * @param   $rows Array of data rows to populate table with.
     * @param   $hideCols Array of names of collumns in row set to not display.
     * @return the text report
     */
	static function getDelimitedReport($title = "", $subTitle = "", $rows, $hideCols = array(), $delimiter = ", ", $fileName="wordList.txt") {
		$report = new DelimitedDataList($title, $subTitle, $rows, $hideCols, $delimiter, $fileName);
		
		return $report->getText();
	}
    
}

