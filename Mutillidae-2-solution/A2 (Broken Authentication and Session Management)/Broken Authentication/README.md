# Broken Authentication
<h1>Broken Authentication and Session Management</h1>
<p>
	Mutillidae2 has several areas which lets us explore this vulnerability, and the different methods an attacker may employ against it. We can exploit them as under.

</p>
<ul>
	<li><h2>Via Brute Force</h2>
		<p>Can be done using Burp Suite via Intruder, but I have done it using a tool called Hydra which is commonly found on Kali Linux. Login mechanism in Mutillidae2 is bruteforcible as it does not have max number of incorrect tries, and hence this flaw can be exploited by the attacker. 
		It is important to know a bruteforce attack, or username enumeration takes time, sometimes 1 day on lesser powerful PC's even when password is only 10 characters long.
		
		</p>
		<p>
			We will try to attack the <b>admin</b> user, and instead of bruteforcing (also Mutillidae2 does not tell us what the min or max password length is ), we will attack this user from a list of most frequently used passwords, which is kind of a dictionary attack and very common. We can find a lot of word lists in the directory, <b>"/usr/share/wordlists"</b>. It is all a matter of hit and trial, but I finally ended up using the file <b>"/metasploit/common_roots.txt"</b> which contains the most common root passwords. Look up THCHydra reference for the usage of the tool for attacking webforms.

		</p>
		<p>
			First, intercepting the outgoing login request using BurpSuite to see the structure of the request, and name of the parameters.<br>
			Second, Notice the access denied or wrong password message which pops up on entering an incorrect password. This will help hydra determine when the login succeeds. Once this is done, we are all set to fire up Hydra to bruteforce the webform through the chosen wordlist. 
		</p>
		<pre>
hydra -l admin -P /usr/share/wordlists/metasploit/common_roots.txt 192.168.13.158 http-post-form "/mutillidae2/index.php?page=login.php:username=^USER^&password=^PASS^&login-php-submit-button=Login&Login:Password incorrect" -V
		</pre>
		<p>
			<b>"Password Incorrect"</b> is the incorrect login message, rest all is self explanatory.
		</p>
	</li>

</ul>