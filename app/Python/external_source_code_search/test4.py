
import requests
from urllib.request import urlopen, Request
from urllib.parse import quote
from bs4 import BeautifulSoup

keyword = "site:www.geeksforgeeks.org Binary Search C++"
keyword = quote(keyword)
results = urlopen(Request("https://www.bing.com/search?q=" + keyword,
                                          data=None, headers={'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10    _11_5) AppleWebKit/537.36 (KHTML, like Gecko) Cafari/537.36'})).read()

soup = BeautifulSoup(results, "html.parser")
for link in soup.find_all('a',href=True):
    if(('http://' in link['href'] or 'https://' in link['href']) and 'bing.com' not in link['href']):
        url = link['href']
        print(url)

