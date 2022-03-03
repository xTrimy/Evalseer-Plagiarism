#include <iostream>
using namespace std;
int main()
{
	int n, i, flag = 0;
	cout << " Enter positive number: ";
	cin >> n;
	for (i = 2; i <= n / 2; i++)
	{
		if (n % i == 0)
		{
			flag = 1;
			break;
		}
	}
	if (flag == 0)
		cout << "This is a Prime Number: " << n;
	else
		cout << " This is Not a Prime Number: " << n;
	return 0;
}