package sample;

import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;

import jdk.internal.util.xml.impl.Input;
import org.omg.PortableInterceptor.USER_EXCEPTION;
import sun.net.www.http.HttpClient;
import sun.nio.cs.StandardCharsets;
import sun.plugin.javascript.navig.Anchor;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.io.*;
import java.net.*;
import java.nio.charset.Charset;
import java.util.Base64;

public class Controller {

    @FXML
    private TextField email_field;
    @FXML
    private PasswordField password_field;
    @FXML
    private Label error_login;

    @FXML
    public void initialize() {

    }
    public void SendCredentials(javafx.event.ActionEvent actionEvent) {
        try {
            URL url = new URL("http://localhost:8000/restful/login");

            HttpURLConnection connection = (HttpURLConnection) url.openConnection();
            connection.setRequestMethod("GET");
            connection.setDoOutput(true);
            connection.setRequestProperty("User-Agent", "Mozzila/5.0");
            connection.setRequestProperty("Content-Type", "application/json");

            OutputStream os = connection.getOutputStream();

            String ss = new String("{\"email\" : \""+email_field.getText()+" \", \"password\" : \""+password_field.getText()+"\"}");
            System.out.println(ss);
            os.write(ss.getBytes("UTF-8"));
            os.flush();
            os.close();

            InputStream content = (InputStream) connection.getInputStream();
            BufferedReader in
                    = new BufferedReader(new InputStreamReader(content));
            String line;
            line = in.readLine();
            System.out.println(line);
            if(line.contains("true")) {
                error_login.setVisible(false);
                error_login.setText("Incorrect credentials");

            } else {
                error_login.setVisible(true);
                error_login.setText("Incorrect credentials");
            }


        } catch (MalformedURLException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
