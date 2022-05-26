import httplib2
from bs4 import BeautifulSoup, SoupStrainer

http = httplib2.Http()
status, response = http.request('https://www.google.com?q=Binary Search C++')

for link in BeautifulSoup(response, parse_only=SoupStrainer('a')):
        if link.has_attr('href'):
                    print(link['href'])
