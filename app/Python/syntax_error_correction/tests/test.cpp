# include < iostream >
 using namespace std ; 
void swap ( int * a , int * b ) { int t = * a ; 
* a = * b ; 
* b = t ; 
} void printArray ( int array [ ] , int size ) { int i ; 
for ( i = 0 ; 
i < size ; 
i ++ ) cout << array [ i ] << " " ;
 cout <<endl ;
 }
 int partition ( int array [ ] , int low , int high ) {
 int pivot = array [ high ] ;
 int i = ( low - 1 ) ;
 for ( int j = low ;
 j <high ;
 j ++ ) {
 if ( array [ j ] <= pivot ) {
 i ++ ;
 swap ( & array [ i ] , & array [ j ] ) ;
 }
 }
 swap ( & array [ i + 1 ] , & array [ high ] ) ;
 return ( i + 1 ) ;
 }
 void quickSort ( int array [ ] , int low , int high ) {
 if ( low <high ) {
 int pi = partition ( array , low , high ) ;
 quickSort ( array , low , pi - 1 ) ;
 quickSort ( array , pi + 1 , high ) ;
 }
 }
 int binarySearch ( int array [ ] , int x , int low , int high ) {
 quickSort ( array , low , high ) ;
 while ( low <= high ) {
 int mid = low + ( high - low ) 2 ;
 if ( array [ mid ] == x ) return mid ;
 if ( array [ mid ] <x ) low = mid + 1 ;
 else high = mid - 1 ;
 }
 return - 1 }
 int main ( ) {
 int arr [ ] = {
 2 , 6 , 5 , 7 , 11 , 4 }
 ;
 int n ;
 cin>> n ;
 cout <<binarySearch ( arr , n , 0 , 4 ) ;
 & 0 ;
 }
