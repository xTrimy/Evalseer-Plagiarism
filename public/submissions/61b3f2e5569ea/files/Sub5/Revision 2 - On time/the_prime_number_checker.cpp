// the prime number checker.cpp : This file contains the 'main' function. Program execution begins and ends there.
//

#include <iostream>
using namespace std;
/**
*Name:Abdel-Rahman Rabee ,220190685
*date:19-12-2019
*introduction to cs -assignment - the prime number checker
*/
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






