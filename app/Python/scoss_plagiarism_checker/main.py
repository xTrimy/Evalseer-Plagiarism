from scoss import Scoss
import sys
import json
import argparse
parser = argparse.ArgumentParser()
parser.add_argument("-l", "--language", required=True)
parser.add_argument("-p", "--path", required=True)
args = parser.parse_args()

try:
    sc = Scoss(lang=args.language)
except ValueError as err:
    print(json.dumps({"error":str(err)}))
    exit(0)

path = args.path.rstrip('/').rstrip('\\')
sc.add_metric('count_operator', threshold=0.3)
sc.add_metric('set_operator', threshold=0.3)
sc.add_metric('hash_operator', threshold=0.3)
sc.add_metric('token_based', threshold=0.5)
sc.add_file_by_wildcard(path+'/**/*.java')
sc.add_file_by_wildcard(path+'/**/*.py')
sc.add_file_by_wildcard(path+'/**/*.cpp')
sc.add_file_by_wildcard(path+'/**/*.plag')
sc.run()
result = []
for i in sc.get_matches(or_thresholds=True):
    source1 = i["source1"].replace(path,'')
    source2 = i["source2"].replace(path, '')
    try:
        source1_author = source1.split('\\')[1]
        source2_author = source2.split('\\')[1]
    except IndexError:
        source1_author = source1.split('/')[1]
        source2_author = source2.split('/')[1]

    if(source1_author == source2_author):
        continue
    i["source1_author"] = source1_author
    i["source2_author"] = source2_author
    result.append(i)
print(json.dumps(result))
