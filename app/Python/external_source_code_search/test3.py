
import requests
from urllib.request import urlopen, Request
from urllib.parse import quote
try:
        from bs4 import BeautifulSoup
except ImportError:
        print("No module named 'bs4' found")
        exit(0)
googleTrendsUrl = 'https://google.com'
response = requests.get(googleTrendsUrl)
if response.status_code == 200:
    g_cookies = response.cookies.get_dict()
keyword = "Binary Search C++ site:www.geeksforgeeks.org"
keyword = quote(keyword)
results = urlopen(Request("https://www.google.com/search?q=" + keyword + "&source=lmns&bih=568&biw=1251&hl=en&sa=X&ved=2ahUKEwix3aaNlMv3AhV8VvEDHay9AiYQ_AUoAHoECAEQAA",
    data=None, headers={'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Cafari/537.36'})).read()

soup = BeautifulSoup(results, "html.parser")
for link in soup.find_all('a',href=True):
    if('/url' in link['href'] and 'google.com' not in link['href']):
        url = link['href'].replace('/url?q=',"")
        print(url)

