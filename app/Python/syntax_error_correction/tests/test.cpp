# include <iostream>
<<<<<<< HEAD
 using namespace std ; 
int n = 5 ; 
int w [ ] = { 3 , 4 , 5 , 2 , 6 } ; 
bool include [ ] = { 0 , 0 , 0 , 0 , 0 } constexpr int W = 13 ; 
bool promising ( int i , int weight , int total ) { return ( ( weight + total >= W ) && ( ( weight == W ) || ( weight + w [ i ] <= W ) ) ) ; 
} void sumOfSubsets ( int i , int weight , int total ) { if ( promising ( i , weight , total ) ) if ( weight == W ) { for ( int x = 0 ; 
x < n ; 
x ++ ) cout << include [ x ] << " " ;
 }
 else { include [ i = true ;
 sumOfSubsets ( i + 1 , weight + w [ i ] , total - w [ i ] ) ;
 include [ i ] = false sumOfSubsets ( i + 1 , weight , total - w [ i ] ) ;
 }
 }
 int main ( ) { int total = 0 ;
 for ( int i = 0 ;
 i < n ;
 i ++ ) total += w [ i ] ;
 sumOfSubsets ( 0 , 0 , total ) ;
 return 0 ;
=======
 int add ( int a , int b ) { return a + b ; 
} int main ( ) int a = 1 ; 
int b = 2 ; 
int sum = 0 ; 
sum = identifier ( a , b ) ; 
std :: cout << " Sum: " << sum << std :: endl ;
>>>>>>> 9067184726ae5d3f3515429a6694b2e52474dd9c
 }
