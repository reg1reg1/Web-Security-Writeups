# A1
<h2>Injection</h2>

<p><i>Injection</i> refers to the process of executing an attack by using the context of interpretation to the attackers advantage. We "inject" something so that the context it is being interpreted in causes it to misbehave and give the attacker some reward. </p>
<p> Example: Say I design a counter-strike game. I display kills like <b>&ltPlayer1&gt</b> killed <b>&ltPlayer2&gt</b>. 
Now , what I am about to demonstrate is in no way a security bug, but just a clever hack to cause a misinterpretation of the sentence. Say Player 1 chooses his name which is something innocous like "Jack" and Player 2, the bastard that he is, chooses his name as "by Me". 
</p>
<p>Now when Player1 kills Player 2, what does the message read? 
<br>Exactly,<i>Jack</i> Killed <i>by Me</i>.Ignoring how the message will be interpreted when Player 2 kills Player 1, this message will ruin Player1's mood quite a bit.
</p>

<p>Injections in practice are exactly like this, taking something out of context to get /access to something we should not have. If the coffee shop guy asks you, "Which coffee?", the expected answer from you will be a flavor , say <i> Capuccino</i>. 
<br>What if the coffee guy is required by some weird rule to give you coffee if it exists. What if you say , the flavor I want is "<i>Cappuccino, and all the money I have</i>" (Weird flavor name). The coffee guy says like a mechanical bot, <i> Here is your "<b>Cappuccino, and all the money I have</b>", Enjoy!. Fortunately , in real life people are smart, and this would give you nothing more than a confused look from the coffee guy.
<p> Unfortunately devices and systems do as they are programmed, they do not know the concept of context per say. They rely on smart programmers to prevent them from being exploited. Injection is nothing but this kind of exploit, in the simplest of sense. 