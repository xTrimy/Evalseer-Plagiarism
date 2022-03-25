import java.util.Scanner;

public class tria {

    public static void main(String args[]){
        Scanner input = new Scanner(System.in);
        int x = input.nextInt();
        int y = input.nextInt();
        int z = input.nextInt();
        Triangle r = new Triangle(x,y,z);
        System.out.print(r.getPerimeter());
    }
    
}

class Triangle {
    int side1,side2,side3;

    public Triangle(int side1, int side2, int side3) {
        this.side1 = side1;
        this.side2 = side2;
        this.side3 = side3;
    }
    
    public int getPerimeter() {
        return this.side1 + this.side2 + this.side3;
    }
}
