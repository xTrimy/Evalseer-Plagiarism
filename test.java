import java.util.Scanner;

public class test {
    public static void main(String args[]){
        Scanner input = new Scanner(System.in);
         int i,fact=1;  
         int number = input.nextInt();//It is the number to calculate factorial    
         for(i=1;i<=number;i++){    
             fact=fact*i;    
         }    
<<<<<<< HEAD
         System.out.print(fact);
=======
         System.out.println(fact);
>>>>>>> 377dde19d370d625f7716738fde57fa2f0b1f5e9
    }  
    
}
