#include <iostream>
using std::cin;
using std::cout;



int main(){
    int x;
    cin >> x;
    cout << multiply(x);
}

int multiply(int x){
    return x*2;
}