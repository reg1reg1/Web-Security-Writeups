<h1>Application Log Injection</h1>
<p>
	Injecting into logs by performing certain actions that will be logged into flat files, or databases behind the scenes. There may be no way of knowing that where the logs will be stored in the backend, however hit and trial of crafted input may be successful in injecting the logs with malicious data.
</p>
<h2> Identification</h2>
<p> Identifying areas which may be logged , such as browsing or GET requests, and the parameters which may get logged. Apache logs may also be injectable. If a backend application reads the logs file,  the vulnerabitlity may be exploited by the Attacker using this newfound out of band channel.
	<ol>
		<li>User agent's</li>
		<li>Form submissions and browsing</li>
		<li>File uploads and downloads</li>
	</ol>
On Mutillidae2 , there exists mainly 2 areas where the user action data is logged.
One of them is the capture-data.php page which writes the incoming request data, to both a flat file and also a database. The other one is the show-log.php which writes to a file/DB but is not vulnerable to SQL injection, nonetheless. Our motive, in any kind of application log injection is to perform certain actions, which when logged will perform unintended and possibly nefarious outcomes on the logs or the end results.

Mutillidae lists the points of Application Log injections as follows. Though these pages are vulnerable to a whole lot of other attacks, our aim here is to perform application log injection.
<b>Note:</b>Almost all pages in Mutillidae2 can be exploited by XSS.
</p>

<b>show-log.php</b>
<p>This page records every action of user on various pages. The primary pages that are recorded here are
as follows. We are only interested in attacking show-log.php so we will ignore other possible attacks such as Path Traversal, Command Injection, File Inclusion etc.
<ol>
	<li>DNS Lookup</li>
	<li>Text Viewer</li>
	<li>Source Viewer</li>
	<li>Document Viewer</li>
	<li>Register User</li>
	<li>Login</li>
	<li>Add to your blog</li>
</ol>
The show-log.php is not SQL injectable, and neither will PHP code injection be successful. PHP code injection is successful only with a select class of PHP functions such as eval. However, <b>show-log.php</b>
does not include any file remotely, or locally and hence we arrive at <b>XSS injection</b> as show-log.php does not encode any HTML characters whatsoever, making way for full blown Cross-site attack.
</p>
<p>The methodology of the attack remains the same for all the pages. Attacked the register user page.
Intercept the outgoing request from the web page using BurpSuite.
We inject into the browser agent this:
<pre>
<script>alert(document.cookie)</script>
</pre>
<b>Note</b>
You may also create a genuine looking popup modal stating session expiry,and steal the entered credentials when entered.
</p>
