module CalculadoraFX {
    requires javafx.controls;
    requires javafx.fxml;

    opens app to javafx.fxml;
    opens app.controller to javafx.fxml;

    exports app;
    exports app.controller;
    // exports app.view;  <-- COMENTADO o ELIMINADO, porque no hay código Java en ese paquete
}