public class Rectangle {
    int width;
    int length;

    public Rectangle(int width, int length) {
        this.width = width;
        this.length = length;
    }
    
    
    public int calculatePerimeter() {
        return (this.length+this.width) *2;
    }
    
}
