package app.controller;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;

import java.util.Random;

public class CalculoController {

    @FXML private TextField oper;
    @FXML private TextField display;

    private int a, b;
    private char op;
    private double correct;
    private boolean answered = true;
    private Random rand = new Random();

    @FXML
    private void initialize() {
        generateOperation();
    }

    private void generateOperation() {
        a = rand.nextInt(20) + 1;
        b = rand.nextInt(20) + 1;
        int choice = rand.nextInt(4);
        switch (choice) {
            case 0: op = '+'; correct = a + b; break;
            case 1: op = '-'; correct = a - b; break;
            case 2: op = '×'; correct = a * b; break;
            case 3:
                b = rand.nextInt(9) + 1;
                a = b * (rand.nextInt(10) + 1);
                op = '÷'; correct = (double) a / b;
                break;
        }
        oper.setText(a + " " + op + " " + b + " =");
        display.setText("");
        answered = false;
    }

    @FXML
    private void appendNumber(ActionEvent e) {
        if (!answered) {
            display.setText(display.getText() + ((Button) e.getSource()).getText());
        }
    }

    @FXML
    private void appendDecimal(ActionEvent e) {
        if (!answered && !display.getText().contains(".")) {
            display.setText(display.getText() + ".");
        }
    }

    @FXML
    private void calculate() {
        if (answered) {
            generateOperation();
            return;
        }

        try {
            double user = Double.parseDouble(display.getText());
            if (Math.abs(user - correct) < 0.001) {
                display.setText("✅");

            } else {
                display.setText("❌");
            }
            answered = true;
        } catch (NumberFormatException e) {
            display.setText("⚠️");
        }
    }
    @FXML
    private void toggleSign(ActionEvent e) {
        String text = display.getText();
        if (text.isEmpty() || text.equals("0")) return;

        if (text.startsWith("-")) {
            display.setText(text.substring(1));
        } else {
            display.setText("-" + text);
        }
    }


    // Métodos auxiliares (dejan la calculadora limpia en modo Brain Training)
    @FXML private void clear() { display.setText("0"); }
    @FXML private void toggleSign() { /* No necesario en modo prueba */ }
    @FXML private void percent() { /* No necesario */ }
    @FXML private void setOperator(ActionEvent e) { /* Operadores solo para UI */ }
}