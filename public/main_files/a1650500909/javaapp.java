import java.util.Scanner;

public class javaapp {

    public static void main(String args[]) {
        Scanner input = new Scanner(System.in);
        int x = input.nextInt();
        int y = input.nextInt();
        int z = input.nextInt();
        Triangle r = new Triangle(x, y, z);
        System.out.print(r.getPerimeter());
    }
}
