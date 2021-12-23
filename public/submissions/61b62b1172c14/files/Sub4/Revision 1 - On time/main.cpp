#include <iostream>

using namespace std;

int main()
{
 int num , counter , y=0 , test=0 ;
        cout << "please insert a number: ";
        cin >> num;
        y = (num/2) ;



        for (counter = 1 ; counter<=y ; counter ++)

        {
            if(num % counter == 0)
            {

            cout << "this number is not prime";
            test = 1 ;
            break ;
            }
        }


       if(test == 0)
            cout << "this number is prime";



    return 0;
}

