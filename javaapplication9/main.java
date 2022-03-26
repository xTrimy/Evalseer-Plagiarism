import java.util.Scanner;

public class main {

    public static void main(String args[]){
        Scanner input = new Scanner(System.in);
        int x = input.nextInt();
        int y = input.nextInt();
        Rectangle r = new Rectangle(x,y);
        System.out.println(r.calculatePerimeter());
    }  
    
}
