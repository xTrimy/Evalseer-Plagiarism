from sctokenizer import CppTokenizer
from sctokenizer import TokenType
import glob
cpp_keywords = ['#include', 'for', 'do-while', 'inline', 'noexcept', 'throw', 'try',
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
                'unsigned', 'using', 'virtual', 'void', 'volatile', 'wchar_t', 'while', 'xor', 'xor_eq', 'and',
                'bitor', 'or', 'xor', 'compl', 'bitand', 'and_eq', 'or_eq', 'xor_eq', 'not', 'not_eq', 'import',
                'module', 'import', 'string', 'cin', 'cout']

tokenizer = CppTokenizer()  # this object can be used for multiple source files

def tokenize(src, return_original=False):
    tokenz = ["START_OF_FILE"]
    original_script = []
    tokenizer_in_string = False
    tokenizer_in_char = False
    with open(src) as f:
        source = f.read()
        tokens = tokenizer.tokenize(source)
        for token in tokens:
            if(token.token_type != TokenType.COMMENT_SYMBOL):
                original_script.append(token.token_value)
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
                elif(token.token_type != TokenType.IDENTIFIER or (token.token_value in cpp_keywords and tokenizer_in_char == False and tokenizer_in_string == False)):
                    tokenz.append(token.token_value)
                else:
                    tokenz.append("IDENTIFIER")
    tokenz.append("END_OF_FILE")
    if(original_script):
        return [tokenz,original_script]
    return [tokenz]


def __main__(path, return_original=False):
    data = tokenize(path,return_original)
    string = ' '.join(data[0])
    if(return_original):
        original_string = ' '.join(data[1])
        return [string,original_string]
    return string
