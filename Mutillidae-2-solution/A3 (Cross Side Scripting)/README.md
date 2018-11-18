# A3
<h1>Cross Side Scripting</h1>

<p><i>Cross Side scripting</i> refers to the injection of javascript into the context of the web page to attack other users who might be accessing the web page. It is usually referred to as "XSS" (CROSS S(Side) S(Scripting)). The XSS attacks can be classified into 3 main categories. XSS is the most widely known and exploited vulnerability under bug bounty hunting. 
</p>
<ol>
	<li><h3>Stored XSS</h3>
		<p>
			Stored XSS , also referred to as persistent XSS is the scenario when the attacker manages to get the malicious to persist in the database. This is usually a severe flaw, and on succeeding the attacker can do a lot of damage.
			The target page is chosen as <b>Add to your Blog</b>. As an attacker, (way harder in real life than what is done in Mutillidae2), we inject the blog post with a malicious XSS script. 
			<pre>
			Hello normal blog, &ltscript&gt alert(document.cookie)&lt/script&gt. Give me your cookies
			</pre>
			Now whoever visits the blog, gets the cookie alert. In the place , we can send the cookies to our page using a AJAX script in the background stealing the document.cookies of the user
			(HTTP only cookies are still secure), but a lot of other damage can be done and affects all users. 
		</p>

	</li>
	<li>
		<h3>Reflected XSS</h3>
		<p>Also, called first order XSS injection. It is a lot more prevalent than the Stored XSS one. Using a malformed URL, (containing the polluted parameter), we can cause the injection to be sent over the url(The polluted parameter is read off the URL) and then injected into the DOM.
		The URL needs to be sent to the malicious user, and needs the user to click on the URL.
		The user info page is the page where a "GET" reflected XSS is possible.
		The url and other fields are injectable in view-user info page to the simplest of xss attack.
	</p>
	</li>
	<li>
		<h3>Reflected DOM Injection</h3>
		<p>
			This beautiful masterpiece of an attack was uncovered in Defcon 21, by security researchers at Trustwave spiderlabs and speakers at Defcon 21. 
			<a href="https://www.defcon.org/html/defcon-21/dc-21-speakers.html#Chechik"/>

		</p>
	</li>
</ol>
