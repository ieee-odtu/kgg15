from os import system
from time import sleep
import urllib
while(True):
	prints=urllib.urlopen("http://localhost/kgg/print.php").read()
	if(prints!="-1"):
		printQueue=prints.split(",")
		for p in printQueue:
			print "KGG> Printing with ID "+str(p)
			c="rundll32 C:\\Windows\\system32\\shimgvw.dll,ImageView_PrintTo \"C:\\wamp\\www\\kgg\\barcode-images\\"+p+".png\" \"BTP-2200E(U) 1\""
			system(c);
	sleep(3)