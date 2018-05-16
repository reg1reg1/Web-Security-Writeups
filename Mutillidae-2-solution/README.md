# Mutillidae2
<h3>Description</h3>

<p>Mutillidae 2 is a better and more feature laden version of prior mutillidae </br>
It is developed by Jeremy Druin. He is a Certified Lead security analyst, and explains a lot of stuff very clearly. He has a channel on youtube <a href="https://www.youtube.com/user/webpwnized!"> webpwnized </a>
and has exhaustive videos on WebApp Security and a ton of other stuff.
Everyone should definitely check him out.

Other CTF's of choice for learning OWASP are DVWA, Mutillidae(2.x is definitely a notch better)

<h3>Setup</h3>
<ol>
<li>Use a Windows XP image as your server machine. If you are sligtly more savvy, you use Metasploitable as well for deploying the vulnerable CTF</li>
<li>I have gone ahead and deployed it to a windows machine</li>
<li>Download Mutillidae2 here(<a href="https://sourceforge.net/projects/mutillidae/">Mutillidae 2</a>)</li>
<ul>Setup WAMP if it is a windows machine
<li>Apache needs to be configured to allow remote access. <br>Note that for WAMP 3 and above, do not
modify the httpd.conf apache file. Use the Vhosts-httpd-conf file insted. It can be done from the WAMP icon
in notification panel, and then modifying Apache configuration files
<li> Your virtual host file should look like this, You can impose more restrictions if you are running the VM's in Bridged mode(connecting directly to the physical network).
<pre>
# Virtual Hosts
#
<VirtualHost *:9999>
  ServerName localhost
  ServerAlias localhost
  DocumentRoot "${INSTALL_DIR}/www"
  <Directory "${INSTALL_DIR}/www/">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require all granted
  </Directory>
</VirtualHost>
</pre>
 </li>  
<li>On some machines , port 80 is blocked by Skype (older versions), you can change 
the<br>port in httpd.conf file</li>
<li>Always remember to restart services after changes</li>
</ul>
<li>For Ubuntu, Fedora users install the rpm packages for phpmyadmin, apache2, php-curl, mysql-server
</br> via YUM/RPM or apt-get depending on Linux flavor.
</li>

</ol>



<h3><u><b>Note</b></u></h3>
<ol>
<li>A lot of solutions here , are inspired by my own tamperings and findings. </li>
<li>Please note that , for many vulnerabilites such as PHP null byte injection, use <b>PHP 5 or lower</b></li>
<li>If you install Ubuntu 16 and above, it will ship with <b>PHP 7.x</b> and you will find a lot of pain trying to install PHP 5.0 (removed from ubuntu sources for 16+).</li>
<li> For some attacks, you have to turn on the allow_url_include in php global configuration, and you can enable allow_url_include from php.ini
<pre>
 /etc/php7/apache2/php.ini

allow_url_include = On
</pre>


I will keep adding more solutions as I find them.

Below are a list of blogs and youtube channels , one should definitely follow for good quality info sec
content. 
