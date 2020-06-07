package sample;

import javafx.application.Platform;
import javafx.collections.FXCollections;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.chart.BarChart;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.XYChart;
import javafx.scene.control.*;
import javafx.scene.layout.Pane;
import javafx.scene.media.Media;
import javafx.scene.media.MediaPlayer;
import javafx.scene.media.MediaView;
import javafx.util.Duration;

import java.io.*;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.nio.file.Paths;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;


public class Controller {

    public LineChart water_level_chart;
    public BarChart concentration_chart;
    public RadioButton radio_region_3;
    public ToggleGroup map_area_group;
    public RadioButton radio_region_2;
    public RadioButton radio_region_1;
    public RadioButton radio_region_6;
    public RadioButton radio_region_4;
    public RadioButton radio_region_5;
    public RadioButton radio_region_7;
    public RadioButton radio_region_8;
    public Button send_credentials;
    public Pane login_pane;
    public Pane home_pane;
    public Pane menu_pane;
    public Pane drone_pane;
    public MediaView drone_video;
    public ComboBox drone_selection;
    public Label field_status;
    public Label pests;
    public Label weeds;
    public Label frostbite;
    public RadioButton Drone1;
    public RadioButton Drone2;
    public RadioButton Drone3;
    public Pane drone_fly_zone;
    public RadioButton Sprinkler1;
    public RadioButton Sprinkler2;
    public ToggleGroup Sprinklers;
    public RadioButton Sprinkler3;
    public Slider sprinkler_slider;
    public LineChart sprinkler_hidration;
    public Pane sprinklers_pane;
    public CheckBox automatic_irrigation_check;
    public Label config_type;
    public Label irrigation_status;
    public Pane user_add_pane;
    public TextField user_add_email;
    public TextField user_add_name;
    public PasswordField user_add_password;
    public Button user_add_button;

    @FXML
    private TextField email_field;
    @FXML
    private PasswordField password_field;
    @FXML
    private Label error_login;


    RadioButton selectedRadio = null;
    Thread runner;
    @FXML
    public void initialize() {
        String [] drones = {"Drone1", "Drone2", "Drone3"};
        drone_selection.setItems(FXCollections.observableArrayList(drones));
        home_pane.setVisible(false);
        menu_pane.setVisible(false);
        drone_pane.setVisible(false);
        user_add_pane.setVisible(false);
        login_pane.setVisible(true);
        sprinklers_pane.setVisible(false);
        runner = new Thread(){
            @Override
            public void run() {
                // TODO OVO GOVNO MOZE DA IZLETI IZVAN PANE-A
                while(true) {
                    try {
                        sleep(1000);
                        if(selectedRadio == null)
                            continue;


                        int direction = (int)(Math.random() * 8);
                        switch (direction) {
                            case 0:
                                selectedRadio.setTranslateY(10);
                                break;
                            case 1:
                                selectedRadio.setTranslateY(-10);
                                break;
                            case 2:
                                selectedRadio.setTranslateX(10);
                                break;
                            case 3:
                                selectedRadio.setTranslateX(-10);
                                break;
                            case 4:
                                selectedRadio.setTranslateX(10);
                                selectedRadio.setTranslateY(10);
                                break;
                            case 5:
                                selectedRadio.setTranslateX(-10);
                                selectedRadio.setTranslateY(10);
                                break;
                            case 6:
                                selectedRadio.setTranslateX(10);
                                selectedRadio.setTranslateY(-10);
                                break;
                            case 7:
                                selectedRadio.setTranslateX(-10);
                                selectedRadio.setTranslateY(-10);
                                break;

                        }
                        Platform.runLater(new Runnable() {
                            @Override
                            public void run() {
                                field_status.setText((int)(Math.random()*10) % 2 == 0 ? "OK" : "There is something wrong!");
                                weeds.setText((int)(Math.random()*10) % 2 == 0 ? "No weeds detected" : "Weeds detected!");
                                pests.setText((int)(Math.random()*10) % 2 == 0 ? "No pests detected" : "Pests detected!");
                                frostbite.setText((int)(Math.random()*10) % 2 == 0 ? "No frostbite" : "Frostbite detected!");
                            }
                        });

                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }

                }
            }
        };
        runner.setDaemon(true);
        runner.start();
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
                home_pane.setVisible(true);
                user_add_pane.setVisible(false);
                menu_pane.setVisible(true);
                drone_pane.setVisible(false);
                login_pane.setVisible(false);
                sprinklers_pane.setVisible(false);

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


    public void change_chart(ActionEvent actionEvent) {
        water_level_chart.getData().clear();
        concentration_chart.getData().clear();
        XYChart.Series series = new XYChart.Series();
        XYChart.Series concentrationSerie = new XYChart.Series();
        concentrationSerie.getData().add(new XYChart.Data("Amonia", (int) (Math.random() * 101)));
        concentrationSerie.getData().add(new XYChart.Data("Salt", (int) (Math.random() * 101)));
        concentrationSerie.getData().add(new XYChart.Data("Nitric Acid", (int) (Math.random() * 101)));
        concentrationSerie.getData().add(new XYChart.Data("Chlorine", (int) (Math.random() * 101)));
        for (int i = 0; i < 5; i++) {
            series.getData().add(new XYChart.Data("Day: "+(i+1), (int) (Math.random() * 50 + 1)));
        }

        water_level_chart.getData().add(series);
        concentration_chart.getData().add(concentrationSerie);

    }

    public void load_home(ActionEvent actionEvent) {
        home_pane.setVisible(true);
        user_add_pane.setVisible(false);
        menu_pane.setVisible(true);
        drone_pane.setVisible(false);
        login_pane.setVisible(false);
        sprinklers_pane.setVisible(false);
    }
    MediaPlayer player;
    Media video;
    public void load_drones(ActionEvent actionEvent) {
        video = new Media(Paths.get("src/sample/areal_video.mp4").toUri().toString());
        player = new MediaPlayer(video);
        player.play();
        player.setMute(true);
        player.setStartTime(new Duration(10000));
        drone_video.setVisible(false);
        drone_video.setMediaPlayer(player);
        home_pane.setVisible(false);
        menu_pane.setVisible(true);
        drone_pane.setVisible(true);
        user_add_pane.setVisible(false);
        login_pane.setVisible(false);
        sprinklers_pane.setVisible(false);

    }

    public void load_sprinklers(ActionEvent actionEvent) {
        home_pane.setVisible(false);
        menu_pane.setVisible(true);
        drone_pane.setVisible(false);
        login_pane.setVisible(false);
        user_add_pane.setVisible(false);
        sprinklers_pane.setVisible(true);
    }

    public void change_drone(ActionEvent actionEvent) {
        Drone1.setVisible(false);
        Drone2.setVisible(false);
        Drone3.setVisible(false);
        drone_video.setVisible(true);
        int selectedIndex = drone_selection.getSelectionModel().getSelectedIndex();
        switch (selectedIndex) {
            case 0:
                player = new MediaPlayer(video);
                player.play();
                player.setMute(true);
                player.setStartTime(new Duration(10000));
                drone_video.setVisible(true);
                drone_video.setMediaPlayer(player);
                Drone1.setVisible(true);
                selectedRadio = Drone1;
                break;
            case 1:
                player = new MediaPlayer(video);
                player.play();
                player.setMute(true);
                player.setStartTime(new Duration(20000));
                drone_video.setVisible(true);
                drone_video.setMediaPlayer(player);
                Drone2.setVisible(true);
                selectedRadio = Drone2;
                break;
            case 2:
                player = new MediaPlayer(video);
                player.play();
                player.setMute(true);
                player.setStartTime(new Duration(30000));
                drone_video.setVisible(true);
                drone_video.setMediaPlayer(player);
                Drone3.setVisible(true);
                selectedRadio = Drone3;
                break;
        }
    }
    XYChart.Series sprinklerSeries;
    Thread sprinkler;
    ArrayList<XYChart.Data> sprinklerData = new ArrayList<>();
    double lastSprinkler = -1;
    String current_config = "";
    double current_level = -1;
    public void change_sprinkler(ActionEvent actionEvent) {
        final String [] configurations = new String[]{
                "Carrots",
                "Potatoes",
                "Potatoes"
        };
        final double [] conviguration_levels = new double[] {
                25,
                50,
                50
        };

        if(Sprinkler1.isSelected()) {
            current_config = configurations[0];
            current_level = conviguration_levels[0];
        } else if (Sprinkler2.isSelected()) {
            current_config = configurations[1];
            current_level = conviguration_levels[1];
        } else {
            current_config = configurations[2];
            current_level = conviguration_levels[2];
        }
        sprinklerData.clear();
        sprinkler_hidration.getData().clear();

        int sprinkler_strength = 0;
        sprinkler_slider.setValue(sprinkler_strength);
        irrigation_status.setText("Unknown");
        sprinklerSeries = new XYChart.Series();
        SimpleDateFormat formatter = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
        Date date;
        for (int i = 0; i < 5; i++) {
            date = new Date() ;
            lastSprinkler =  Math.min(100, (int) (Math.random() * 101) + (int) (sprinkler_strength * 0.9));
            XYChart.Data dat = new XYChart.Data(formatter.format(date),  Math.min(100, lastSprinkler));
            sprinklerSeries.getData().add(dat);
            sprinklerData.add(dat);
        }
        sprinkler_hidration.getData().add(sprinklerSeries);
        sprinkler = new Thread(() -> {
            while (true) {
                try {
                    if(automatic_irrigation_check.isSelected()){
                        Platform.runLater(new Runnable() {
                            @Override
                            public void run() {

                                config_type.setText(current_config);
                                XYChart.Data d = (XYChart.Data) sprinklerSeries.getData().get(sprinklerSeries.getData().size() - 1);
                                int dd = (int) d.getYValue();
                                lastSprinkler = dd;
                                sprinkler_slider.setValue(Math.min(100, Math.abs(dd - current_level)));
                            }
                        });

                    };
                    Thread.sleep(5000);
                    SimpleDateFormat formatter1 = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
                    Date date1 = new Date();
                    XYChart.Data dat = new XYChart.Data(formatter1.format(date1),  Math.min(100,((int) (Math.random() * 50) + (int) (sprinkler_slider.getValue() * 0.9) )* (sprinkler_slider.getValue() == 0 ? 0 : 1)));

                    Platform.runLater(new Runnable() {
                        @Override
                        public void run() {
                            sprinklerSeries.getData().remove(0);
                            sprinklerSeries.getData().add(dat);
                            String status = "";
                            if(lastSprinkler <= current_level * 0.25) {
                                status = "Really bad!";
                            } else if( lastSprinkler > current_level * 0.25 && lastSprinkler <= current_level * 0.5) {
                                status = "Bad";
                            } else if(lastSprinkler > current_level * 0.5 && lastSprinkler <= current_level * 0.75 ) {
                                status ="OK";
                            } else if (lastSprinkler > current_level * 0.75 && lastSprinkler <= current_level){
                                status ="Excelent";
                            } else {
                                status = "Bad";
                            }

                            irrigation_status.setText(status);
                        }
                    });

                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
            }
        });
        sprinkler.setDaemon(true);
        sprinkler.start();
    }

    public void logout(ActionEvent actionEvent) {
        home_pane.setVisible(false);
        menu_pane.setVisible(false);
        drone_pane.setVisible(false);
        user_add_pane.setVisible(false);
        login_pane.setVisible(true);
        sprinklers_pane.setVisible(false);
    }

    public void AddUserMethod(ActionEvent actionEvent) {
        home_pane.setVisible(false);
        menu_pane.setVisible(true);
        drone_pane.setVisible(false);
        user_add_pane.setVisible(true);
        login_pane.setVisible(false);
        sprinklers_pane.setVisible(false);
    }

    public void AddUser(ActionEvent actionEvent) {
        FileWriter myWriter = null;
        try {

            String user = user_add_name.getText();
            String email = user_add_email.getText();
            String password = user_add_password.getText();
            if (user.equalsIgnoreCase("") || email.equalsIgnoreCase("") || password.equalsIgnoreCase("")) {
                return;
            }
            myWriter = new FileWriter("localUsers.txt", true);
            BufferedWriter br = new BufferedWriter(myWriter);
            PrintWriter printWriter = new PrintWriter(new BufferedWriter(br));
            printWriter.println("{ 'user' : '"+user+"', 'email' : '"+email+"', 'password' : '" + password+ "' },");
            printWriter.close();
            myWriter.close();
        } catch (IOException e) {
            e.printStackTrace();
        }

    }
}
