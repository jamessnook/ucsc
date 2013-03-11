<table width="760" border="0" cellspacing="0" cellpadding="5" bgcolor="#FFFFCC">
  <tr> 
    <td>
	<cfform name="checktutee" action="selecttutee2action.cfm">
    <cfif isDefined("error")>
    	<cfif error eq "noID"><p class="red">ERROR: The form was not submitted properly. Please try again</p>
        </cfif>
    </cfif>     
        	<p> 
      <p><font face="Arial, Helvetica, sans-serif" size="2"><b>Please type in 
        the SID or the Name (partial or complete) of the student you wish to view, and click on the Submit button.</b></font></p>
      <p><font face="Arial, Helvetica, sans-serif" size="2">SID 
        <input type="text" name="id" maxlength="9">
        </font></p>
      <p><font face="Arial, Helvetica, sans-serif" size="2">or</font></p>
      <p><font face="Arial, Helvetica, sans-serif" size="2">Name 
        <input type="text" name="Name">
        </font></p>
      <p> 
        <input type="hidden" name="formSent" id="formSent" value="checktutee" />
        <input type="submit" name="Submit" value="Submit">
        <input type="button" value="Cancel and Go Back" onClick="history.go(-1)">
      </p>
	 </cfform>
    </td>
  </tr>
</table>
</body>
</html>
