<h1>SQL Injection</h1>
<p> SQL injection is when the User Input Data injects something that uses the context interpretation of that entered data to the attacker's advantage. It can do anything from leaking useful data like password hashes to destroying the entire database or spawn an OS shell to the attacker, if unchecked. It still remains as one of the most potent form of injections that a site can be vulnerable to as it attacks a backend datastore.
</p>
<h2> Identification</h2>
<p> Identifying the SQL injection points are the first step, every point must be checked and marked that one encounters during reconnaisance or crawling, sitemap generation etc. Key areas could be.
	<ol>
		<li>Form submissions, registrations, change password etc</li>
		<li>GET URL's typically pagination requests</li>
		<li>Ajax requests behind the scenes that periodically submit user data</li>
		<li>Feedback or comment forms in shopping sites</li>
		<li>User-Agent might be getting logged somewhere in DB, try to inject that as well</li>
	</ol>
<h2>Execution</h2>
<p>
After identifying a suitable entry point, begin your attack. It goes without saying that ensure you have full permission to perform the attack, and the client has backup of the datastore or any crucial data, as the attack could have unforseen consequences. Here we are going to practice on CTF Mutillidae2 so this can be kept aside for now.
</p>
<p>You can attack manually and when some info is revealed ,you may proceed for tools or other complex types of attack. There is no checklist , hacking is all about creativity and above all patience.
So keep digging away until you're sure that the injection point is protected.
</p>

<ol>
	<li>Manually submit values via browser interface</li>
	<ul>
		<li>Will be prevented by Client side scripting(Stupid Level 2)</li>
		<li>Not hackery enough, doesn't give you the feel good</li>
	</ul>
	<li>
		Use a good'ol script that behaves like a browser. Attached the most simple script possible in pytnon
		using Mechanize. (sqlinjection.py) for the User-Info challenge.
	</li>
	<li>
		Use the grand daddy SQLMap tool. More on how to use sqlmap can be found by reading the man page.
		SQLMap ships by default with Kali Linux.
		<ul>
			<li>
				<p>Start by locating sqlmap if it is already installed<p>
				<pre>
locate sqlmap.py
				</pre>
				Traverse to the directory, which will be "/usr/share/sqlmap" , if it is installed
			</li>
			<li>
				First step is to find out, the action URL i.e where the data is being submitted. There are many ways to do this, but I prefer doing it via the proxy of WebExploit tool BurpSuite, by PortSwigger.
				The request URL and method type must be indentified. In this case, the GET request reflects in the URL and can be copied from there. <br> In Burp Suite this can be done using the inbuilt proxy and copying th details from there. <br> We now use the URL with SQLMap as follows.<br> The values of the username and password do not matter,those keys will be used by SQLMap for injection.
				The 
				<pre>
./sqlmap.py -u "http://192.168.16.1:9999/mutillidae2/index.php?page=user-info.php&username=alibaba&password=dotcom&user-info-php-submit-button=View+Account+Details" --dbs  
				</pre>
				</li>
				<li>
					The above command will display the databases that could be accessed, use "<b>-D &ltDatabaseName&gt</b>" , and <b>--tables</b>to see tables for the database.
					<pre>
./sqlmap.py -u "http://192.168.16.1:9999/mutillidae2/index.php?page=user-info.php&username=alibaba&password=dotcom&user-info-php-submit-button=View+Account+Details" --dbs -D nowasp --tables
					</pre>
					</li>
					<li>
						Once ,tables are displayed,a table name can be selected using "<b>-T &lttableName&gt</b>" and display columns using "<b>--columns</b>"
						<pre>
./sqlmap.py -u "http://192.168.16.1:9999/mutillidae2/index.php?page=user-info.php&username=alibaba&password=password&user-info-php-submit-button=View+Account+Details" --dbs -D nowasp -T accounts --columns
						</pre>
</li>
<li>
	The data from the selected columns can be done by specifying the value "<b>-C &ltcolumn1,column2&gt</b>", and and dump the data using the option "<b>--dump</b>".
</li>
</li>
</ol>
<h2> Different Attack Purpose</h2>
<h3> Extracting Data </h3>
<p>Aim is to extract data via SQL injection, typically attacking inputs where there is a probable of SQL SELECT statement in the background. Attacking Mutillidae2. The demo shown under Execution covers this and also the sqlinjection.py which cracks the injection. At Level 5, Mutillidae2 should be unbreakable, so any hacks found should be reported as bug to the developer.</p>

<h3>1.Bypasing Authentication</h3>

<p>Typical statements where, authentication can be bypassed as an example of SQL injection</p>
A mechanism to bypass authentication via injecting login. Attack via simple command, and try to guess admin username. You can attack via SQLMap, but for learning sake we are gonna manually pass the parameters. On level 2, this method can be used via proxy tool of your choice.


So bypassing the login in Mutillidae2 is pretty easy-peezy lemon squeazy. You just inject the good'ol string <b><i>admin' or 1=1#</i></b>.

<h3>2.Insert based Injection </h3>

Upon identifying an Insert based injection, it is important to know that he Insert statement is the best place to perform what is called a second order SQL Injection if the condition is right.
We can always use the Insert statement to bypass the entries in the database which should not be possible in otherwise normal case.  In Mutillidae2 , the Insert based injection causes the query to break, hence we cannot work with Second order SQL Injection.
Insert SQL statement has this structure. Our injection could be any one or more of the values.
<pre>INSERT INTO blahTABLE(col1,col2,col3) VALUES(val1,val1,val2)</pre>
<p>The values must match the number of columns and also the datatype. We may not always know the number of paramaters before hand, or what type is required by the database.</p><p>Fortunately this shortcoming can be easily bypassed. 
The trick is to start by hit and trial method for the number of parameters, and the type check can be bypassed by using an Integer as it is typecasted into a string by most databases.
Attempts could look like following to guess the number of parameters until the attack is successfull.
<pre>
xxx') -- 
xxx',1) -- 
xxx',1,1) -- 
</pre>
and so on , until you guess the right number of columns that exist. A similar kind of trick can be used with UNION statements to guess the number of columns and their datatypes.

The mutillidae2 solution is to forge a date into the blog, which should be non existent.
<ol>
	<li>
		<b>Add to your blog page<b> can be SQL injected to change the date of the blog, the Insert statement can be easily injected by using this query.  
		<pre>I have some aladeen news','2019-09-09 00:00:00')#</pre>
		<b>Note: I have been trying for a Second order injection, but have not been able to do it</b>
		<p>The user is taken from the cookie and PHPSESSID and unforgeable, so we are left only with the option of the date which only accepts a date and the string of the blog</p>.
		<p>I have so far managed to pull off an error based injection. I am still looking for a way to post the results of the injected SELECT query into the blog itself but haven't been successful
		Adding the below into the blog, we get an error message notifying us of the password of the user admin, and that it does not qualify for a date.
		</p>
		<pre>
			hacker',(SELECT password FROM accounts WHERE username LIKE '%admin' ))#
		</pre>

	</li>
	<li>
		<b>Register yourself page</b>
		You can register by using data from other columns as one of the fields. We cannot however read from <b>the same table</b> we are INSERTING into. Hence unfortunately we cannot read from the accounts table (containing username and password). We can however get crucial column Name by using these. We are targeting the metainfo stored in <b>information_schema </b>. In Oracle we would target all_tabs_columns. 
		Put the following in the username field of registration page. The field we are injected into is the signature field. Since we cannot read from accounts , we can definitely try to read from the vulnerable <b><i>mysql.user</i></b>. The first two queries are when you want to scan the tables for columns. 
		<pre>
			hacker','1',(SELECT column_name from information_schema.columns where table_name='accounts' and column_name LIKE '%user%' LIMIT 1))#
			hacker','1',(SELECT column_name from information_schema.columns where table_name='accounts' and column_name LIKE '%pass%' LIMIT 1))#
			hacker','1',(select password from mysql.user where user=’root’ LIMIT 0,1)#
		</pre>  
	</li>
</ol>
</p>
