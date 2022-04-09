import main as tokenizer
import sys
import json



check_for_array = ["return in main"]
for feature in check_for_array:
    check_for_return = tokenizer.token_checker(check_for=feature)
    if(not check_for_return):
        json_data = {"status":"warning","checker":"return in main", "found":"false"}
        print(json.dumps(json_data))
        exit(0)

json_data = {"status":"success"}
print(json.dumps(json_data))
