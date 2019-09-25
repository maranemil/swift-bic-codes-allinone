import requests
import urllib.request
import time
from bs4 import BeautifulSoup
import re
import os

"""
def unique(list1):   
    unique_list = []       
    for x in list1: 
        if x not in unique_list: 
            unique_list.append(x) 
    for x in unique_list: 
        print(x,)
"""

arFilename = []
arSubdirname = []
for dirname, dirnames, filenames in os.walk('.'):
    # print path to all subdirectories first.
    for subdirname in dirnames:
        # print(os.path.join(dirname, subdirname))
        subdirnameStr = str(os.path.join(dirname, subdirname))
        if subdirnameStr.find("swift"):
            arSubdirname.append(subdirnameStr)

    # print path to all filenames.
    for filename in filenames:
        # print(os.path.join(dirname, filename))
        filenameStr = str(os.path.join(dirname, filename))
        arFilename.append(filenameStr)

    # Advanced usage:
    # editing the 'dirnames' list will stop os.walk() from recursing into there.
# if '.git' in dirnames:
# don't go into any .git directories.
# dirnames.remove('.git')

# print(*arSubdirname, sep='\n')
# swift-code-

rooturl = 'http://localhost/wwweb/scrap_bic/'

def scrap(url):
    response = requests.get(url)
    soup = BeautifulSoup(response.text, "html.parser")
    links = soup.findAll('a')
    linksAhref = []
    for lnk in links:
        linksAhref.append(lnk['href'])
    return linksAhref


for x in arSubdirname:
    # if x.find("swift"):
    p = re.compile(r"swift")
    m = p.match(x)
    if m:
        print(x)

# print (rooturl + arSubdirname[66])

# rootlinks = scrap()
# print(*rootlinks, sep='\n')

"""	

rootlinks = scrap(rooturl)
#print(*rootlinks, sep='\n')

lv2link = []
for lnk in rootlinks:	
	parseUrl = rooturl+lnk
	arLv2 = scrap(parseUrl)
	for ahrefLv2 in arLv2:
		if re.match("country/start-with", ahrefLv2):
			lv2link.append(ahrefLv2)
print(*lv2link, sep='\n')


lv3ink = []
for lnk2 in lv2link:	
	parseUrl2 = rooturl+lnk2
	print(parseUrl2)
	arLv3 = scrap(parseUrl2)
	for ahrefLv3 in arLv3:
		lv3ink.append(ahrefLv3)
print(*lv3ink, sep='\n')
"""

"""
lv2rootlinks = []
for rootlnk in rootlinks:
	if re.match("country/start-with", rootlnk):
		urllv2 = 'http://localhost/wwweb/scrap_bic/'+rootlnk
		responselv2 = requests.get(urllv2)
		souplv2 = BeautifulSoup(response.text, "html.parser")
		lv2links = souplv2.findAll('a')

		for lv2lnk in lv2links:
			lv2rootlinks.append(lv2lnk['href'])



#lv2rootlinksu = unique(lv2rootlinks) 
#print(*lv2rootlinksu, sep='\n') # prettify v1

#prettify v2
for word in lv2rootlinks:
    print (word)
"""

# one_a_tag = soup.findAll('a')[36]
# link = one_a_tag['href']
# print(link)

# download_url = ‘http://web.mta.info/developers/'+ link
# urllib.request.urlretrieve(download_url,’./’+link[link.find(‘/turnstile_’)+1:])
# time.sleep(1)

# https://towardsdatascience.com/how-to-web-scrape-with-python-in-4-minutes-bc49186a8460


"""
https://github.com/scrapy/scrapy/blob/master/scrapy/http/request/__init__.py

class ExampleSpider(BaseSpider):
   name = "example"
   start_urls = ["file:///path_of_directory/example.html"]

   def parse(self, response):
       print response
       hxs = HtmlXPathSelector(response)

"""
