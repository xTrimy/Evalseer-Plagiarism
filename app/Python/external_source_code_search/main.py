from escodesearcher import SearchCode
import sys
import json

keyword = sys.argv[1]

source_codes = SearchCode().search(keyword)

print(json.dumps({"codes":source_codes}))
