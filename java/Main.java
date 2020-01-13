public class Main {
    static {
        System.loadLibrary("example");
    }

    public static void main(String[] args) {
        System.out.println("int("+imgutil("icon_128.png")+")");
        System.exit(0);
    }

    static native int imgutil(String path);
}
