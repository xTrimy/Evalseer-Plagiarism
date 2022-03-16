#include <iostream>
using namespace std;

int main() {
    int n;
    int factorial = 1;

    int a = 0;
    cin >> n;
<<<<<<< HEAD
    cout << "The output is" << n*2;
=======

    // for(int i=0;i<1000000;i++){
    //     a++;
    // }

    if (n < 0) {
        cout << "Error! Factorial of a negative number doesn't exist.";
    } else {
        for (int i = 1; i <= n; ++i) {
            factorial *= i;
        }
        cout << factorial;    
    }

>>>>>>> 2f8e6d7abc2fbd9f8c10fc3e2971db56d86821ea
    return 0;
}