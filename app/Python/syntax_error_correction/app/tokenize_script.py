
from os import replace
import re
def __main__(path,return_original = False):
    path2 = path
    cpp_keywords = ['#include','for', 'do-while', 'inline', 'noexcept', 'throw', 'try',
    'catch', 'const', 'volatile', 'typedef', 'new', 'delete', 'this', 'friend',
    'override', 'final', 'alignas', 'alignof', 'and', 'and_eq', 'asm', 'auto',
    'bitand', 'bitor', 'bool', 'break', 'case', 'catch', 'char', 'char8_t',
    'char16_t', 'char32_t', 'class', 'compl', 'concept', 'const', 'consteval',
    'constexpr', 'constinit', 'const_cast', 'continue', 'co_await', 'co_return', 
    'co_yield', 'decltype', 'default', 'delete', 'do', 'double', 'dynamic_cast', 'else',
    'enum', 'explicit', 'export', 'extern', 'false', 'float', 'for', 'friend', 'goto',
    'if', 'inline', 'int', 'long', 'mutable', 'namespace', 'new', 'noexcept', 'not',
    'not_eq', 'nullptr', 'operator', 'or', 'or_eq', 'private', 'protected', 'public',
    'reflexpr', 'register', 'reinterpret_cast', 'requires', 'return', 'short', 'signed',
    'sizeof', 'static', 'static_assert', 'static_cast', 'struct', 'switch', 'template', 'this',
    'thread_local', 'throw', 'true', 'try', 'typedef', 'typeid', 'typename', 'union',
    'unsigned','using','virtual','void','volatile','wchar_t','while','xor','xor_eq','and',
    'bitor','or','xor','compl','bitand','and_eq','or_eq','xor_eq','not','not_eq','import',
    'module','import','string','cin','cout']

    tokenz = ["OPERATOR","IDENTIFIER","NUMERIC_LITERAL","STRING_LITERAL","==","+=","-=","*=","%=","<<=",">>=","&=","&&","||",">","<",
              '"', "'", "\\", "/", ";", ",", ".", ">>", "<<", "RELATIONAL_OPERATOR", '=', '}', '{', '(', ')', "{", "}", ">>", "<<", "+", "-", "*", "/", "%", "++", "--"]
    with open(path2, 'r') as file:
        str1 = file.read()

    old_strings = []
    single_quoted = re.compile('\'[^\']*\'')
    for value in single_quoted.findall(str1):
        old_strings.append(value)
        str1 = str1.replace(value," STRING_LITERAL ")

    double_quoted = re.compile('"[^"]*"')
    for value in double_quoted.findall(str1):
        old_strings.append(value)
        str1 = str1.replace(value, " STRING_LITERAL ")

    semicolon = re.compile("(;)(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')")
    for value in semicolon.findall(str1):
        str1 = str1.replace(value, " ; ")
    

    # equal = re.compile("(=)(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')")
    # for value in equal.findall(str1):
    #     str1 = str1.replace(value, " = ")

    brace_left = re.compile("({)(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')")
    for value in brace_left.findall(str1):
        str1 = str1.replace(value, " { ")
    
    
    brace_right = re.compile("(})(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')")
    for value in brace_right.findall(str1):
        str1 = str1.replace(value, " } ")

    square_left = re.compile("([)(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')")
    for value in square_left.findall(str1):
        str1 = str1.replace(value, " [ ")

    square_right = re.compile("(])(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')")
    for value in square_right.findall(str1):
        str1 = str1.replace(value, " ] ")

    bracket_left = re.compile("(\()(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')")
    for value in bracket_left.findall(str1):
        str1 = str1.replace(value, " ( ")

    bracket_right = re.compile("(\))(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')")
    for value in bracket_right.findall(str1):
        str1 = str1.replace(value, " ) ")
    numeric = []
    numberic_letirals = re.compile("(?<![A-Za-z0-9.])[+-]?[0-9.]+")
    for value in numberic_letirals.findall(str1):
        numeric.append(value)
        str1 = str1.replace(value, " NUMERIC_LITERAL ")

    str1 = re.sub('//.*?\n|/\*.*?\*/', '', str1, flags=re.S)
    operators = [">>","<<","+","-","*","/","%","++","--"]
    # for i in operators:
    #     op = re.compile("(\\"+i+")(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')")
    #     for value in op.findall(str1):
    #         str1 = str1.replace(value, " OPERATOR ")

    for word in cpp_keywords:
        op = re.compile("("+word+")(?![^\"]*\"|[^\"\"]*\")(?![ ^ ']*'|[^''] *')")
        for value in op.findall(str1):
            str1 = str1.replace(value, " "+word+" ")


    relational_operator = ["!=","!",">=","<=",">","<","==","&&","||"]


    arr = str1.split()
    arr_original_code = arr.copy()
    string_count = 0
    numeric_count = 0
    for index,i in enumerate(arr):
        if(i == "STRING_LITERAL"):
            arr_original_code[index] = old_strings[string_count]
            string_count+=1
        if(i == "NUMERIC_LITERAL"):
            arr_original_code[index] = numeric[numeric_count]
            numeric_count += 1
        if(i not in cpp_keywords and i not in tokenz and i not in relational_operator):
            arr[index] = " IDENTIFIER "
    string = ' '.join(arr)
    string_original = ' '.join(arr_original_code)
    if(return_original):
        return [string,string_original]
    return string

