#include <iostream>
using namespace std;

int main()
{
	int n, i;
	bool isprime = true;

    cout << "Enter a positive integer: ";
	cin >> n;

	for (i = 2; i <= n / 2; ++i)
	{
		if (n % i == 0)
		{
			isprime = false;
			break;
		}
	}
	if (isprime)
		cout << "this is a prime  number";
	else
		cout << "this is not a brime number";
	return 0;
}