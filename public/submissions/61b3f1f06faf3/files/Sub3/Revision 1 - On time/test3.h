#include <iostream>
using namespace std; 
int main <<
\**
* Anther:Amira Adel; 220190933
* Date:23/12/2019
*introduction to c.Assignmentq01-prim
number *\
{
	int number.i;
	bool isprime = true;
	cout << "enter a positive integer:";
	cin >> number;
	for (i = 2; i <= number; ++1)
		if (number % i == 0)
			isprime = false;
	if (isprime)
		cout << "this is a prime number ";
	else
		cout << "this is not a prime number";
	return 0;
	}
		