<h1>Google xss Challenges</h1>
<p> To spread XSS awareness, Google created 6 XSS challenges.</p>
They can be found here. 
<a href="https://xss-game.appspot.com/">https://xss-game.appspot.com/</a>
<ul>
	<li><h2>Challenge 1</h2>
		<p> As simple as it gets, simple XSS injection with plain old javascript</p>
		<pre>&ltscript&gtalert(1)&lt/script&gt</pre>
		</li>
<li><h2>Challenge 2</h2>
<p> Simple attack won't work here,as they are escaping the '&lt' and '&gt' symbols. So we can
	use and inject the attributes. This can be done by using the value tag's value to your advantage.
	I have used the onmouseover as many developers blacklist the onload attribute.
	<pre>
&lth1&gt onmouseover="alert(1)"voila&lt/h1&gt
	</pre>
</p>
</li>
<li><h2>Challenge 3</h2>
<p>The images src attribute is injectable in this challenge. So what we do is ecape the context of the
url of src by using an invalid url and a<b>'</b>and then inject an onerror attribute to cause the alert.
Also, not forgetting that this pseudo browser interface is primitive and won't encode the URL automatically, so encoding the injected URL as well.
<pre>
'onerror="alert(1)"/>
Base64 encoded: %27onerror%3D%22alert%281%29%22%2F%3E
</pre>
</p>
</li>
<li><h2>Challenge 4</h2>
<p>
In this challenge we have a timer, but the value being input to the timer is injectable.
This one is different in the sense, in that it requires a closer inspection of the context we are injecting into, and hence it makes it difficult.We find that the html is being rendered via a templating engine,and hence the values are being escaped correctly. So we have to target the javascript code, and escape the javascript context which we do so by doing the following input in the timer value.
<pre>
4');alert('1;
</pre>
</p>
</li>
<li><h2>Challenge 5</h2>
<p>
	This requires the use of a new concept. After clicking on the signup tag, we are brought to a page with the option to enter email address. The first instinct would be to try and inject the obvious text field. But we are in Challenge 5 now, so whom are we kidding? We can try nonetheless, but that field is protected and sanitized well. 
</p>
<p>
	The next thing that raises a red flag is that the next parameter, at the bottom href tag takes value directly from the URL. Hence that too is a point of user input injection. What is pretty obvious then is we can perform an unvalidated redirect attack on this page. However,that is not the aim. The way to inject a href tag with javascript executable code as shown below
</p>
<pre>
javascript:alert(1)
</pre>
</li>
<li>
	<h2>Challenge 6</h2>
	<p>Multiple ways of solving this, but all require the knowledge of a not so common concept.
		There is a way to transmit web content using just an URI containing base64 encoded data, and is
		RFC standard. This method is called DataURi. More information on this can be found here.
		<br>
		<a href="https://en.wikipedia.org/wiki/Data_URI_scheme">Data URI Wikipedia</a><br>
		And this paper on phishing without using any web page,just a data URI. <br>
		<a href="http://klevjers.com/papers/phishing.pdf">Paper PDF Link</a>
		Once this is known, the injection becomes easy.
		<pre>
data:text/javascript,alert(1)
		</pre>
	</p>
</li>
</ul>

