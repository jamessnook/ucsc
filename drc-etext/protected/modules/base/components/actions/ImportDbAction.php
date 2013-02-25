<?php

/**
 * ImportDBAction
 * =============
 * Basic functionality to load the database from an sql file.
 * 
 * Code found on an old web posting and slightly modified for use here
 * 
 * see: http://stackoverflow.com/questions/147821/loading-sql-files-from-within-php
 * see: http://www.frihost.com/forums/vt-8194.html
 * 
 * Comments from the borrowed code below:
 * 
 ************************************************************************
 *                             sql_parse.php
 *                          -------------------
 *     begin                : Thu May 31, 2001
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: sql_parse.php,v 1.8 2002/03/18 23:53:12 psotfx Exp $
 *
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 *   These functions are mainly for use in the db_utilities under the admin
 *   however in order to make these functions available elsewhere, specifically
 *   in the installation phase of phpBB I have seperated out a couple of
 *   functions into this file.  JLH
 *
 **************************************************************************
 *
 * @author JSnook 
 * @package drc-etext.protected.extensions.components
 */
class ImportDBAction extends CAction {
    /**
     * Path of the import folder.
     * @var string
     */
    public $path='protected/data/';

    /**
     * Name of the import file.
     * @var string
     */
    public $fileName='import.sql';

    /**
     * The main action that handles the database import request.
      */
    public function run( ) {
		$fileRoot =dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..';
		$connection=Yii::app()->db;   
		//$command=$connection->createCommand("SOURCE $fileRoot/$fileName");
		//$command->execute(); 
	   	//exec("{$sqlPath}mysql --protocol=TCP --host=localhost --port=10000 --user=u9WnUzhdw1Umf --password=pK5UtdeHbHRdT dea9019de8a924cb68da744cddc6d19db < $fileRoot/$fileName");
		//$this->redirect(Yii::app()->homeUrl);
		set_time_limit ( 0 );
		$dbms_schema = "$fileRoot/$this->path$this->fileName";
		echo $dbms_schema . '  ';
		
		$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('problem ');
		$sql_query = $this->remove_remarks($sql_query);
		$sql_query = $this->split_sql_file($sql_query, ';');
		$i=1;
		foreach($sql_query as $sql){
			if ($i%100==0)
				echo "$i ";
				$command=$connection->createCommand($sql);
				$command->execute(); 
				//mysql_query($sql) or die('error in query');
			$i++;
		}		
    }
    
	//
	// remove_comments will strip the sql comment lines out of an uploaded sql file
	// specifically for mssql and postgres type files in the install....
	//
	public function remove_comments(&$output)
	{
	   $lines = explode("\n", $output);
	   $output = "";
	
	   // try to keep mem. use down
	   $linecount = count($lines);
	
	   $in_comment = false;
	   for($i = 0; $i < $linecount; $i++)
	   {
	      if( preg_match("/^\/\*/", preg_quote($lines[$i])) )
	      {
	         $in_comment = true;
	      }
	
	      if( !$in_comment )
	      {
	         $output .= $lines[$i] . "\n";
	      }
	
	      if( preg_match("/\*\/$/", preg_quote($lines[$i])) )
	      {
	         $in_comment = false;
	      }
	   }
	
	   unset($lines);
	   return $output;
	}
	
	//
	// remove_remarks will strip the sql comment lines out of an uploaded sql file
	//
	public function remove_remarks($sql)
	{
	   $lines = explode("\n", $sql);
	
	   // try to keep mem. use down
	   $sql = "";
	
	   $linecount = count($lines);
	   $output = "";
	
	   for ($i = 0; $i < $linecount; $i++)
	   {
	      if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
	      {
	         if (isset($lines[$i][0]) && $lines[$i][0] != "#")
	         {
	            $output .= $lines[$i] . "\n";
	         }
	         else
	         {
	            $output .= "\n";
	         }
	         // Trading a bit of speed for lower mem. use here.
	         $lines[$i] = "";
	      }
	   }
	
	   return $output;
	
	}
	
	//
	// split_sql_file will split an uploaded sql file into single sql statements.
	// Note: expects trim() to have already been run on $sql.
	//
	public function split_sql_file($sql, $delimiter)
	{
	   // Split up our string into "possible" SQL statements.
	   $tokens = explode($delimiter, $sql);
	
	   // try to save mem.
	   $sql = "";
	   $output = array();
	
	   // we don't actually care about the matches preg gives us.
	   $matches = array();
	
	   // this is faster than calling count($oktens) every time thru the loop.
	   $token_count = count($tokens);
	   for ($i = 0; $i < $token_count; $i++)
	   {
	      // Don't wanna add an empty string as the last thing in the array.
	      if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
	      {
	         // This is the total number of single quotes in the token.
	         $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
	         // Counts single quotes that are preceded by an odd number of backslashes,
	         // which means they're escaped quotes.
	         $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
	
	         $unescaped_quotes = $total_quotes - $escaped_quotes;
	
	         // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
	         if (($unescaped_quotes % 2) == 0)
	         {
	            // It's a complete sql statement.
	            $output[] = $tokens[$i];
	            // save memory.
	            $tokens[$i] = "";
	         }
	         else
	         {
	            // incomplete sql statement. keep adding tokens until we have a complete one.
	            // $temp will hold what we have so far.
	            $temp = $tokens[$i] . $delimiter;
	            // save memory..
	            $tokens[$i] = "";
	
	            // Do we have a complete statement yet?
	            $complete_stmt = false;
	
	            for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
	            {
	               // This is the total number of single quotes in the token.
	               $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
	               // Counts single quotes that are preceded by an odd number of backslashes,
	               // which means they're escaped quotes.
	               $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
	
	               $unescaped_quotes = $total_quotes - $escaped_quotes;
	
	               if (($unescaped_quotes % 2) == 1)
	               {
	                  // odd number of unescaped quotes. In combination with the previous incomplete
	                  // statement(s), we now have a complete statement. (2 odds always make an even)
	                  $output[] = $temp . $tokens[$j];
	
	                  // save memory.
	                  $tokens[$j] = "";
	                  $temp = "";
	
	                  // exit the loop.
	                  $complete_stmt = true;
	                  // make sure the outer loop continues at the right point.
	                  $i = $j;
	               }
	               else
	               {
	                  // even number of unescaped quotes. We still don't have a complete statement.
	                  // (1 odd and 1 even always make an odd)
	                  $temp .= $tokens[$j] . $delimiter;
	                  // save memory.
	                  $tokens[$j] = "";
	               }
	
	            } // for..
	         } // else
	      }
	   }
	
	   return $output;
	}

    
}
