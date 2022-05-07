import requests
from urllib.request import urlopen, Request
googleTrendsUrl = 'https://google.com'
response = requests.get(googleTrendsUrl)
if response.status_code == 200:
    print(response)
    g_cookies = response.cookies.get_dict()
    print(g_cookies)
keyword = "google"
print (urlopen(Request("https://www.google.co.in/search?q=" + keyword + "&tbm=isch&tbs=sur%3Afc&hl=en&ved=0CAIQpwVqFwoTCKCa1c6s4-oCFQAAAAAdAAAAABAC&biw=1251&bih=568",data=None,headers={'User-Agent':'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Cafari/537.36'})).read())
