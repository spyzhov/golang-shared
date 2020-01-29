import java.net.*;
import java.io.*;
import java.nio.file.*;
import java.util.HashMap;
import java.util.Map;
import java.lang.StringBuilder;

public class Main {
    static {
        System.loadLibrary("example");
    }

    public static void main(String[] args) {
        String url = "http://localhost:8080/management/health";
        System.out.println("IMAGE_SIZE");
        printImageSize("example.png");

        try {
            System.out.println("HTTP_SERVE");
            httpServe(8080);
            String content = readUrlAsString(url);
            System.out.println("Got from " + url + ":\n" + content);

            System.out.println("JSON_PATH");
            System.out.println(JSONPath("$.service", content));

            String example = readFileAsString("example.json");
            System.out.println("For example: \n" + example);
            HashMap<String, String> examples = new HashMap();
            examples.put("$..author", "all authors");
            examples.put("$.store..price", "the price of everything in the store");
            examples.put("$..book[(@.length-1)]", "the last book in order");
            examples.put("$..book[?(@.price<10)]", "filter all books cheapier than 10");
            for (Map.Entry<String, String> entry : examples.entrySet()) {
                String key = entry.getKey();
                String value = entry.getValue();

                System.out.println("\n\t" + value + ": " + key);
                System.out.println("      "+JSONPath(key, example));
            }

        } catch (Exception e) {
            System.out.println(e);
            System.exit(1);
        }
        System.exit(0);
    }

    private static String readUrlAsString(String uri) throws Exception {
        URL oracle = new URL(uri);
        BufferedReader in = new BufferedReader(new InputStreamReader(oracle.openStream()));

        StringBuilder result = new StringBuilder();
        String inputLine;
        while ((inputLine = in.readLine()) != null) {
            result.append(inputLine);
        }
        in.close();
        return result.toString();
    }

    public static String readFileAsString(String fileName) throws Exception {
        String data = "";
        data = new String(Files.readAllBytes(Paths.get(fileName)));
        return data;
    }

    static native int printImageSize(String path);

    static native void httpServe(int port);

    static native String JSONPath(String path, String json);
}
