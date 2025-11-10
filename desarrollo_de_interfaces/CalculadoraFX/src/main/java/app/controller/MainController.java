package app.controller;

import javafx.fxml.FXML;

public class MainController {

    @FXML
    private void launchCalculadora() {
        AppLauncher.launchApp("Calculadora", "/app/view/calculadora.fxml");
    }

    @FXML
    private void launchCalculoMental() {
        AppLauncher.launchApp("Cálculo Mental", "/app/view/calculo.fxml");
    }

    @FXML
    private void launchSudoku() {
        AppLauncher.launchApp("Sudoku", "/app/view/sudoku.fxml");
    }

    @FXML
    private void exitApp() {
        javafx.application.Platform.exit();
    }
}