"""
pip3 install beautifulsoup4
"""
import urllib.request
from bs4 import BeautifulSoup
import csv
import argparse
nbrPage = -1
countPage = 1

url = 'https://www.nytimes.com/books/best-sellers/combined-print-and-e-book-nonfiction/' #premier page
#url = 'https://www.nytimes.com/books/best-sellers/2011/02/20/combined-print-and-e-book-nonfiction/' #avant dernier page
#url = 'https://www.nytimes.com/books/best-sellers/2011/02/13/combined-print-and-e-book-nonfiction/' #dernier page

def scrapingPage(url):
	global countPage
	global nbrPage
	print ("Page: "+url)
	# Fetching the htmlcss-iouqpc
	request = urllib.request.Request(url)
	content = urllib.request.urlopen(request)# Parsing the html 
	parse = BeautifulSoup(content, 'html.parser')# Provide html elements' attributes to extract the data 
	text1 = parse.find_all('h3', attrs={'class': 'css-5pe77f'})
	text2 = parse.find_all('p', attrs={'class': 'css-hjukut'})# Writing extracted data in a csv file
	nextPage = parse.find('div', attrs={'class': 'css-iouqpc'}).find("a" , recursive=False).attrs
	if 'href' in nextPage.keys():
		nextPage = nextPage["href"]
	else:
		nextPage = False
	with open('out/index-'+str(countPage)+'csv', 'a') as csv_file:
	  writer = csv.writer(csv_file, delimiter=',', quotechar='"', quoting=csv.QUOTE_ALL)
	  writer.writerow(['Title','Author'])
	  countPage = countPage + 1
	  for col1,col2 in zip(text1, text2):
	    writer.writerow([col1.get_text().strip(), col2.get_text().strip()])
	return scrapingPage('https://www.nytimes.com'+nextPage.strip()) if nextPage and (countPage<=nbrPage or nbrPage <0) else "Done"

ap = argparse.ArgumentParser()
ap.add_argument('-n','--nbrPage', required=False , type=int, help='integer pour nombre page')
args = vars(ap.parse_args())
nbrPage = args['nbrPage'] if args['nbrPage'] else nbrPage
print (scrapingPage(url))
