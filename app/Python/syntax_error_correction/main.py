import app.predict_next_token as predict_next_token
import app.tokenize_script as tokenize_script
import sys
import os
import re
import json
import pathlib
from dotenv import load_dotenv
load_dotenv()
MINGW_EXE = os.environ.get("MINGW_EXE")
ASTYLE_EXE = os.environ.get("ASTYLE_EXE")

file_path = sys.argv[1]
main_directory = pathlib.Path(__file__).resolve().parent

def test_solution(test_array, index, token, method):
    code_array = test_array.copy()
    test_array = ' '.join(test_array)
    test_array = re.sub(
        "({)(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')", r'\1\n', test_array, flags=re.S)
    test_array = re.sub(
        "(;)(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')", r'\1\n', test_array, flags=re.S)
    test_array = re.sub(
        "( ; )", r"\1\n".replace(" ",""), test_array, flags=re.S)
    test_array = re.sub(
        "(<[\w]+?>)", r'\1\n', test_array, flags=re.S)
    f = open(str(main_directory)+"/tests/test.cpp", "w")
    f.write(test_array)
    f.close()
    os.system(ASTYLE_EXE + " --style=allman " + str(main_directory)+"/tests/test.cpp > " + str(main_directory)+"/log.txt 2>&1")
    os.system(MINGW_EXE + " " + str(main_directory)+"/tests/test.cpp -o "+str(main_directory)+"/tests/test > " + str(main_directory)+"/log.txt 2>&1")
    if(os.path.exists(str(main_directory)+"/tests/test.exe")):
        os.remove(str(main_directory)+"/tests/test.exe")
        f = open(str(main_directory)+"/tests/test.cpp", "r")
        file_contents = f.read()
        line_number = 0
        error_index = 0
        for i,value in enumerate(file_contents.split('\n')):
            tokens = value.split()
            for j in tokens:
                if(error_index == index):
                    line_number = i
                error_index += 1
        json_data = {"status": "success", "solution": file_contents,
                     "token": token, "line": line_number+1, "method":method}
        print(json.dumps(json_data))
        # print("Solution worked \"tests/test.cpp\"")
        return True
    # os.remove(str(main_directory)+"/tests/test.cpp")
    return False

def main(file):
    file_path = ""
    try:
        file_path = file
    except NameError:
        file_path = input("Enter file name:")
    
    output = os.system(MINGW_EXE + " " + str(main_directory) +"/"+file_path+' > ' + str(main_directory)+'/log.txt 2>&1')
    
    if(len(str(output))>0):
        text = tokenize_script.__main__(path=file_path,return_original=True)
        tokenized_text = text[0]
        original_text = text[1]
        original_text_array = original_text.split()
        predicted_tokenz = predict_next_token.__main__(tokenized_text)

        # Primary predictions
        for i in predicted_tokenz:
            primary_prediction = i[0]
            # Insertion trial
            # print("Predicted "+primary_prediction[1]+" at index of " +
            #   str(primary_prediction[0])+" instead of "+original_text_array[primary_prediction[0]] + " or before it")
            # print("Testing the solution...")
            test_array = original_text_array.copy()
            test_array.insert(primary_prediction[0], primary_prediction[1])
            result = test_solution(test_array, primary_prediction[0],primary_prediction[1], 1)
            if(result == True):
                return [primary_prediction[1],primary_prediction[0],0]
            # Substitution trial
            test_array = original_text_array[:primary_prediction[0]] + [primary_prediction[1]] + original_text_array[primary_prediction[0] + 1:]
            result = test_solution(test_array, primary_prediction[0], primary_prediction[1], 2)
            if(result == True):
                return [primary_prediction[1], primary_prediction[0], 1]
            
            # Removing Trial
            # test_array = original_text_array[:primary_prediction[0]] + original_text_array[primary_prediction[0] + 1:]
            # result = test_solution(test_array)
            # if(result == True):
            #     return [primary_prediction[1], primary_prediction[0], 2]
    
    print(json.dumps({"status": "no solution"}))
    # predict_next_token.main()


if __name__ == "__main__":
    main(file_path)
