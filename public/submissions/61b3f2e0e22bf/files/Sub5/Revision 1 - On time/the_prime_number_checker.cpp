// the prime number checker.cpp : This file contains the 'main' function. Program execution begins and ends there.
//

#include <iostream>
using namespace std;
int main() {
	int x, y;
	bool isprime = true;
	cout << "entre the intger" << endl;
	cin >> x;
	for (y = 2; y <= x / 2; ++y)
	{
		if (x % y == 0)
		{
			isprime = false;
			break;
		}
	}
	if (isprime)
		cout << "this is is a prime  number ";
	else 
		cout << "this is not a prime number ";
	return 0;
}


