<?php

#include('init.php');
include('functions.php');

print_header($username);

?>

<H2 align=center> Cyclerestorer.com Sign Up </H2>

<BR>

<H2 align=center>Join now for free!</H2>

<SCRIPT TYPE="text/javascript">
function check_form() {
var errs=0;
if (document.forms.signup.first_name.value == '') {alert('Please enter your first name'); errs=1;}
else if (document.forms.signup.last_name.value == 0) {alert('Please enter your last name'); errs=1;}
else if (document.forms.signup.username.value == '') {alert('Please enter a username'); errs=1;}
else if (document.forms.signup.username.value.length > 20) {alert('Your username is too long. Please enter a username less than 20 characters.'); errs=1;}
else if (document.forms.signup.password.value.length > 20) {alert('Your password is too long. Please enter a password less than 15 characters.'); errs=1;}
else if (checkMail()) {alert('Please enter a valid email address'); errs=1;}
else if (document.forms.signup.password.value == '') {alert('Please enter a password'); errs=1;}
else if (document.forms.signup.password.value != document.forms.signup.password2.value) {alert('Please make sure password is typed the same as in confirm password'); errs=1;}
else if (!document.forms.signup.terms.checked) {alert('Please check the box indicating that you are 13 or older and accept the terms of use'); errs=1;}
return (errs==0);
}

function checkMail()
{
	var x = document.forms.signup.email.value;
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (filter.test(x)) return false;
	else return true;
}

</SCRIPT>

<TABLE ALIGN=CENTER>
<TR><TD valign=top>

<FORM NAME=signup ACTION=newuser.php METHOD=POST onSubmit="return check_form();">
<TABLE align=center bgcolor=eeeeee width=300>
<TR><TH colspan=2 bgcolor=79888E>New Users Signup</TH>
</TR>
<TR><TD colspan=2 align=center>
<FONT COLOR=FF0000>*</FONT> indicates required fields
</TD></TR>
<TR>
<TD>First Name <FONT COLOR=FF0000>*</FONT></TD>
<TD><INPUT TYPE=TEXT NAME=first_name></TD>
</TR>
<TR>
<TD>Last Name <FONT COLOR=FF0000>*</FONT></TD>
<TD><INPUT TYPE=TEXT NAME=last_name></TD>
</TR>
<TR>
<TD>Email <FONT COLOR=FF0000>*</FONT></TD>
<TD><INPUT TYPE=TEXT NAME=email></TD>
</TR>
<TR>
<TD>Username <FONT COLOR=FF0000>*</FONT></TD>
<TD><INPUT TYPE=TEXT NAME=username></TD>
</TR>
<TR>
<TD>Password <FONT COLOR=FF0000>*</FONT></TD>
<TD><INPUT TYPE=PASSWORD NAME=password></TD>
</TR>
<TR>
<TD>Confirm Password <FONT COLOR=FF0000>*</FONT></TD>
<TD><INPUT TYPE=PASSWORD NAME=password2></TD>
</TR>
<TR><TD valign=top>Verification Image <FONT COLOR=FF0000>*</FONT><BR>
<A HREF=http://en.wikipedia.org/wiki/Image_Verification target=_new>what's this?</A>
</TD>
<TD valign=top>
<TABLE>
<TR><TD valign=top><IMG SRC=image_verification.php></TD>
<TD valign=top>
<INPUT TYPE=TEXT NAME=verifyimage SIZE=9>
</TD></TR></TABLE>

</TD></TR>

<TR><TD colspan=2 align=center><BR>




<INPUT TYPE=checkbox NAME=terms> <A HREF=terms.php target=_new>I have read and accept the terms of use</A><BR><BR>
<INPUT TYPE=SUBMIT VALUE="Create Account"></TD></TR>
</TABLE>
</FORM>

</TD>

<TD valign=top>


</TD>
</TR>
</TABLE>

<?php
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
#mysql_close ($Link);
print_footer($username);
?>