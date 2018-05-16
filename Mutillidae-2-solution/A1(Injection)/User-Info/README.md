# A1
<h2>User Info</h2>

<p>Easily modifiable, and hackable.
This one breaks down with the simplest and most trivial, <i><b>a' or 1=1</b></i>.
This causes the <i>"WHERE"</i> clause to return true and all the user details are displayed without any hassle. We have successfully used SQLINJECTION to get our hands on sensitive data.
</p>

<p>
	<h3>Note</h3>
	Please do not go about trying inserting SQL injection based input on webistes not owned by you, or sites on which you do not have permissions to perform tests on. Modern architectures have IDS setup which will monitor suspicious activity ,and report your IP. 
</p>

<p>Execution</p>
<ol>
	<li>Manually enter values into browser</li>
	<ul>
		<li>Will be prevented by Client side scripting(Stupid Level 2)</li>
		<li>Not hackery enough, doesn't give you the feel good</li>
	</ul>
	<li>
		Use a good'ol script that behaves like a browser. Attached the most simple script possible in pytnon
		using Mechanize. (sqlinjection.py). It can be modified to be bit smart and adaptive. For now it snipes on the User Info page.
	</li>
	<li>
		Use the grand daddy SQLMap tool. How to use sqlmap can be found by reading the man page.
		SQLMap ships by default with Kali Linux.	
	</li>
</ol>
