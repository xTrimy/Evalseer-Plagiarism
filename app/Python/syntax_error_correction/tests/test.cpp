# include <iostream>
using namespace std ;
int n = 5 ;
int w [ ] = { 3, 4, 5, 2, 6 } ;
bool arr [ ] = { 0, 0, 0, 0, 0 } ;
int W = 13 ;
bool promising ( int i, int weight, int total )
{
    return ( ( weight + total >= W ) && ( ( weight == W ) || ( weight + w [ i ] <= W ) ) ) ;
}
void sumOfSubsets ( int i, int weight, int total )
{
    if ( promising ( i, weight, total ) ) if ( weight == W ) {
            for ( int x = 0 ;
                    x < n ;
                    x ++ ) cout << arr [ x ] << " " ;
        } else {
            arr [ i ] = true ;
            sumOfSubsets ( i + 1, weight + w [ i ], total - w [ i ] ) ;
            arr [ i ] = false ;
            sumOfSubsets ( i + 1, weight, total - w [ i ] ) ;
        }
}
int main ( )
{
    int total = 0 ;
    for ( int i = 0 ;
            i < n ;
            i ++ ) total += w [ i ] ;
    sumOfSubsets ( 0, 0, total ) ;
    return 0 ;
}
