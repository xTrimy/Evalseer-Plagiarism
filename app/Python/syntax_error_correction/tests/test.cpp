# include <iostream>
 using namespace std ; 
template <typename T>
 void merge ( T * ar , T * ar2 , int low , int mid , int high ) { int i = low ; 
int j = low ; 
int z = mid + 1 ; 
while ( ( i <= mid ) && ( z <= high ) ) { if ( ar [ i ] <= ar [ z ] ) { ar2 [ j ] = ar [ i ] ; 
i ++ ; 
} else { ar2 [ j ] = ar [ z ] ; 
z ++ ; 
} j ++ ; 
} if ( i > mid ) { for ( int k = z ; 
k <= high ; 
k ++ ) { ar2 [ j ] = ar [ k ] ; 
j ++ ; 
} } else { for ( int k = i ; 
k <= mid ; 
k ++ ) { ar2 [ j ] = ar [ k ] ; 
j ++ ; 
} } for ( int k = low ; 
k <= high ; 
k ++ ) { ar [ k ] = ar2 [ k ] ; 
} } template <typename T>
 void mergeSort ( T * a , T * b , int low , int high ) { int mid ; 
if ( low < high ) { mid = ( low + high ) / 2 ; 
mergeSort ( a , b , low , mid ) ; 
mergeSort ( a , b , mid + 1 , high ) ; 
merge ( a , b , low , mid , high ) ; 
} } int main ( ) { int a [ ] = { 2 , 6 , 5 , 7 , 11 , 4 } ; 
int b [ 6 ] = { 0 } ; 
mergeSort ( a , b , 0 , 5 ) ; 
for ( int i = 0 ; 
i < 6 ; 
i ++ ) { cout << a [ i ] << " " ;
 }
 return 0 ;
 }
