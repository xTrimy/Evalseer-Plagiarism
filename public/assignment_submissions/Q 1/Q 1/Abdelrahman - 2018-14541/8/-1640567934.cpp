#include <iostream>
using namespace std;

int main() {
    int n;
    int factorial = 1;

    int a=0;
    cin >> n;

    for(int i=0;i<100000;i++){
        a++;
    }

    if (n < 0)
        cout << "Error! Factorial of a negative number doesn't exist.";
    else {
        for(int i = 1; i <= n; ++i) {
            factorial *= i;
        }
        cout << factorial;    
    }

    return 0;
}