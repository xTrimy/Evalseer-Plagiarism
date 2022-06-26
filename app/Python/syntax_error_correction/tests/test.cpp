# include <iostream>
 using namespace std ; 
<<<<<<< HEAD
# define n 5 int w [ ] = { 3 , 4 , 5 , 2 , 6 } ; 
bool include [ ] = { 0 , 0 , 0 , 0 , 0 } constexpr int W = 13 ; 
=======
int n = 5 ; 
int w [ ] = { 3 , 4 , 5 , 2 , 6 } ; 
" include [ ] = { 0 , 0 , 0 , 0 , 0 } ; 
int W = 13 ; 
>>>>>>> 0d7ea14d44f8e95003591293d712cfe383ca6ca0
bool promising ( int i , int weight , int total ) { return ( ( weight + total >= W ) && ( ( weight == W ) || ( weight + w [ i ] <= W ) ) ) ; 
} void sumOfSubsets ( int i , int weight , int total ) { if ( promising ( i , weight , total ) ) if ( weight == W ) { for ( int x = 0 ; 
x < n ; 
x ++ ) cout << include [ x ] << " " ;
 }
 else { include [ i ] = true ;
 sumOfSubsets ( i + 1 , weight + w [ i ] , total - w [ i ] ) ;
<<<<<<< HEAD
 include [ i ] = false ;
 sumOfSubsets ( i + 1 , weight , total - w [ i ] ) ;
=======
 include [ i ] = false sumOfSubsets ( i + 1 , weight , total - w [ i ] ) ;
>>>>>>> 0d7ea14d44f8e95003591293d712cfe383ca6ca0
 }
 }
 int main ( ) int total = 0 ;
 for ( int i = 0 ;
 i < n ;
 i ++ ) total += w [ i ] ;
 sumOfSubsets ( 0 , 0 , total ) ;
 return 0 ;
 }
