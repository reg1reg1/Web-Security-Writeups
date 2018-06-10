# A2
<h1>Broken Authentication and Session Management</h1>
<p> The focus here is to enter a restricted location. 
In real life what do people do to get to restricted location? Take an example, if someone wants to enter your house, and assuming it is locked. If not , that would be a case of "Broken Access Control" in security terms, and that is covered under A-4. The inplace lock of our house will be the first defense in place to prevent anyone without key. If the lock is strong, and the key is difficult to be guessed and forged by the thief, we can say in security terms , it represents a strong encryption. Does it mean it ensures security? No, as the thief may find multiple ways to exploit other weaknesses, break a window, steal your key, impersonate as you and get someone from the inside to open the door, or wait for you to go in and leave the door open etc. These attack scenarios have very relatable counterparts in the cyber world as well. 
</p>

<p><h2>Broken Authentication</h2>
This refers to a problem in the authentication mechanism, or the lock of your house itself. It could be that it is a weak lock, or that it provides a default key which can be guessed by people trying to break in ,or that the key is repeated such that many people end up having the same lock key pair, which the attacker can break in. Mutillidae2 does not cover many other nuances of breaking authentication such as forgotten password, and response analysis, timing based attacks etc.
</p>

<p><h2>Incorrect Session Management</h2>

This refers to the flaws in incorrect session handling. Eg, incorrect session termination or validation, session tokens that can be reverse engineered, keeping sessions with very less entropy, incorrect backend handling of sessions, or exposing them over some logs etc. Session tokens must be protected throughout their lifetime for secure session handling. Apart from this the session token itself should not disclose any meaningful information, and encoding, encryption and obfuscation of meaningful information is not secure enough.

</p>
<p>Mutillidae2 offers some demo's in which we can use few of the authentication and session bypass techniques</p>
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
			The correct password is revealed to be <b>adminpass</b>.The <b>"Password Incorrect"</b> is the incorrect login message, rest all is self explanatory.
		</p>
	</li>
	<li>
		<h2>Privilege Escalation</h2>
		<p>
			Instead of attacking authentication directly, we will target the session handling this time in various ways.
			<ul>
				<li><h3>Cookie tampering</h3>
					<p>
						The Mutillidae cookies reveal everything, and this allows a user to bruteforce through them. Using Intruder, of Burpsuite try to access the <b> login.php </b> page. 
					</p>
					<p>
						Firstly to see how a session is maintained we must log in. For this create any user, and login using this user. After this each subsequent request to Mutillidae2 will carry a session cookie. Identify the session cookie, by identifying the extra parameter which gets added to the cookie, which was not present during guest browsing. 
					</p>
					<p>
						Next task in a real world scenario would be to analyze the entropy of the cookie, which is very high for the <b>PHPSESSID</b> cookie. Entropy analysis can be done in Burp Suite via a tool called the Sequencer. However  Mutillidae2 has only one session cookie which is stored in the <b>uid</b>. The parameter <b>username</b> is not bound to the tokens, and this only makes the task easier. 
					</p>
				</li>
				<li>
					<h3>CBC Bit Flipping</h3>
					<p>Everyone knows that ECB is the worst possible way of block mode encryption, CBC mode can be exploited as well.The way CBC is decrypted is a small change in the ith cipher text block will cause the ith block of plaintext to fully change to possible gibberish. However, the ith cipher text is used to decipher the next block is XOR'ed, hence i+1th block plaintext will only undergo a change a small change. </p>
				</li>
			</ul>
		</p>
	</li>
</ul>

