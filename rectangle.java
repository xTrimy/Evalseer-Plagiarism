import java.util.Scanner;

public class rectangle{  
    public static void main(String args[])  
    {  
        Scanner input = new Scanner(System.in);
        int width = 0;  
        int height = 0; 
        
        width = input.nextInt();
        height = input.nextInt();

        System.out.print(calculateArea(width,height));
        System.out.print(calculateArea(width, height));
     }  

     public static int calculateArea(int width, int height) {
         return width*height;
     }
}