from sctokenizer import CppTokenizer
from sctokenizer import JavaTokenizer
from sctokenizer import PhpTokenizer
from sctokenizer import TokenType
import argparse
parser = argparse.ArgumentParser()
parser.add_argument("-l", "--language", required=True)
parser.add_argument("-f", "--first", required=True)
parser.add_argument("-s", "--second", required=True)
args = parser.parse_args()
if(args.language == 'cpp'):
    tokenizer = CppTokenizer()
elif(args.language == 'java'):
    tokenizer = JavaTokenizer()
elif(args.language == 'php'):
    tokenizer = PhpTokenizer()
else:
    print(json.dumnps({"error": "Unsupported language: "+args.language}))
    exit(0)
    
def tokenize(tokens):
    tokenz = []
    original = []
    tokenizer_in_string = False
    tokenizer_in_char = False

    for token in tokens:
        if(tokenizer_in_char):
            tokenz.append("CHAR_LITERAL")
            continue
        if(tokenizer_in_string):
            tokenz.append("STRING_LITERAL")
            continue
        if(token.token_value == '"'):
            tokenizer_in_string != tokenizer_in_string
        if(token.token_value == "'"):
            tokenizer_in_char != tokenizer_in_char
        if(token.token_type == TokenType.CONSTANT):
            tokenz.append("CHAR_LITERAL")
        elif(token.token_type == TokenType.STRING):
            tokenz.append("STRING_LITERAL")
        elif(token.token_type != TokenType.IDENTIFIER and ( tokenizer_in_char == False and tokenizer_in_string == False)):
            tokenz.append(token.token_value)
        else:
            tokenz.append("IDENTIFIER")
        original.append(token.token_value)
    lines = []
    lines_original = []
    current_line_original = ""
    current_line = ""
    braces_count=0
    for index,i in enumerate(tokenz):
        if(i == "=" or i == "<" or i == ">>" or  (i == "IDENTIFIER" and tokenz[index-1] != "<") or i == "<<" or i == "*"):
            current_line += " "
            current_line_original += " "
        current_line += i
        current_line_original += original[index]
        if(i == "=" or i == ">" or i == "using" or (i == "IDENTIFIER" and tokenz[index+1] != ">") or i == ">>" or i == "<<" or i == "*"):
            current_line += " "
            current_line_original += " "
        if(index+1 < len(tokenz)):
            if(i == ">" or (i == "}" and tokenz[index+1] != ";") or i == "{" or i == ";"):
                lines.append(current_line)
                lines_original.append(current_line_original)
                current_line = ""
                current_line_original = ""
                if(i == "{"):
                    braces_count += 1
                    end_braces = False
                if(tokenz[index+1] == "}"):
                    braces_count -= 1
                    end_braces = True
                for j in range(0, braces_count):
                    current_line += "\t"
                    current_line_original += "\t"
        else:
            if(end_braces):
                lines.append("}\n")
                lines_original.append("}\n")
            else:
                lines.append("\n")
                lines_original.append("\n")
    return [lines, lines_original]


# # Open File in Read Mode
# file_1 = open('data/MergeSort.cpp', 'r')
# file_2 = open('data/mrg.cpp', 'r')

# print("Comparing files ", " @ " + 'data/MergeSort.cpp',
#       " # " + 'data/mrg.cpp', sep='\n')

# file_1_line = file_1.readline()
# file_2_line = file_2.readline()

# # Use as a COunter
# line_no = 1

# print()
tokenized_file1 = []
original_file1 = []
tokenized_file2 = []
original_file2 = []
with open(args.first) as file:
    source = file.read()
    tokens = tokenizer.tokenize(source)
    t = tokenize(tokens)
    tokenized_file1 = t[0]
    original_file1 = t[1]
with open(args.second) as file:
    source = file.read()
    tokens = tokenizer.tokenize(source)
    t = tokenize(tokens)
    tokenized_file2 = t[0]
    original_file2 = t[1]
same = set(tokenized_file1).intersection(tokenized_file2)

similar_in_file_1 = []
similar_in_file_2 = []
for line in same:
   
    line_number_1 = tokenized_file1.index(line)
    line_number_2 = tokenized_file2.index(line)
    similar_in_file_1.append([line_number_1,line_number_2])
    similar_in_file_2.append([line_number_2, line_number_1])
data = {
    "similarities":similar_in_file_1,
    "source_code_1": original_file1,
    "source_code_2": original_file2,
}
import json
print(json.dumps(data))
# print('\n')
# print("Difference Lines in Both Files")
# while file_1_line != '' or file_2_line != '':

#     # Removing whitespaces
#     file_1_line = file_1_line.rstrip()
#     file_2_line = file_2_line.rstrip()

#     # Compare the lines from both file
#     if file_1_line != file_2_line:

#         # otherwise output the line on file1 and use @ sign
#         if file_1_line == '':
#             print("@", "Line-%d" % line_no, file_1_line)
#         else:
#             print("@-", "Line-%d" % line_no, file_1_line)

#         # otherwise output the line on file2 and use # sign
#         if file_2_line == '':
#             print("#", "Line-%d" % line_no, file_2_line)
#         else:
#             print("#+", "Line-%d" % line_no, file_2_line)

#         # Print a empty line
#         print()

#     # Read the next line from the file
#     file_1_line = file_1.readline()
#     file_2_line = file_2.readline()

#     line_no += 1

# file_1.close()
# file_2.close()
