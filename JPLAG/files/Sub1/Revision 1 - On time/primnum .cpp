#include <iostream>
using namespace std;
int main()
{
  int z, y;
  bool isPrime = true;
  do
  cout << "Enter an integer number: ";
  cin >> z;
  for(y= 2; y <= z / 2; ++y)
  {
      if(z % y == 0)
      {
          isPrime = false;
          break;
      }
  }
  if (isPrime)
      cout << "This is a prime number" ;
  else
      cout << "This is not a prime number" ;
     } while(z!= -1);
  return 0;
}
