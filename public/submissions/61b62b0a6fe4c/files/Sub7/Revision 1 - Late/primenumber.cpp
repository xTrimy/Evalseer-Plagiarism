#include "primenumber.h"
#include<iostream>
using namespace std;
int main()
{
	int y;
	cout << "enter the number ";
		cin >> y;
		int z = 0;
		for (int i = 1; i <= y; i++)
			if (y % i == 0)
				z++;
		if (z == 2)
			cout  << "the number is prime ";
		else
			cout  << "the number is not number";
			return 0;











}