package app.controller;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;

public class CalculadoraController {

    @FXML
    private TextField display;

    private double operand1 = 0;
    private String pendingOperator = "";
    private boolean startNewInput = true;

    @FXML
    private void appendNumber(ActionEvent event) {
        String digit = ((Button) event.getSource()).getText();
        if (startNewInput) {
            display.setText(digit);
            startNewInput = false;
        } else {
            String current = display.getText();
            if ("0".equals(current) && !digit.equals("0")) {
                display.setText(digit);
            } else {
                display.setText(current + digit);
            }
        }
    }

    @FXML
    private void appendDecimal(ActionEvent event) {
        if (startNewInput) {
            display.setText("0.");
            startNewInput = false;
        } else if (!display.getText().contains(".")) {
            display.setText(display.getText() + ".");
        }
    }

    @FXML
    private void setOperator(ActionEvent event) {
        String op = ((Button) event.getSource()).getText();
        if (!pendingOperator.isEmpty()) {
            calculate();
        }
        operand1 = parseDisplay();
        pendingOperator = op;
        startNewInput = true;
    }

    @FXML
    private void calculate() {
        if (pendingOperator.isEmpty()) return;

        double operand2 = parseDisplay();
        double result = 0;

        switch (pendingOperator) {
            case "+":
                result = operand1 + operand2;
                break;
            case "-":
                result = operand1 - operand2;
                break;
            case "*":
                result = operand1 * operand2;
                break;
            case "/":
                if (operand2 != 0) {
                    result = operand1 / operand2;
                } else {
                    display.setText("Error");
                    reset();
                    return;
                }
                break;
            default:
                return;
        }

        display.setText(formatResult(result));
        reset();
    }

    @FXML
    private void clear() {
        display.setText("0");
        reset();
    }

    @FXML
    private void toggleSign() {
        String current = display.getText();
        if ("0".equals(current) || "Error".equals(current)) return;

        if (current.startsWith("-")) {
            display.setText(current.substring(1));
        } else {
            display.setText("-" + current);
        }
    }

    @FXML
    private void percent() {
        try {
            double value = parseDisplay() / 100.0;
            display.setText(formatResult(value));
            startNewInput = true;
        } catch (NumberFormatException e) {
            display.setText("Error");
        }
    }

    private double parseDisplay() {
        try {
            return Double.parseDouble(display.getText());
        } catch (NumberFormatException e) {
            return 0;
        }
    }

    private String formatResult(double value) {
        if (Double.isNaN(value) || Double.isInfinite(value)) {
            return "Error";
        }
        if (value == (long) value) {
            return String.valueOf((long) value);
        } else {
            return String.valueOf(value);
        }
    }

    private void reset() {
        operand1 = 0;
        pendingOperator = "";
        startNewInput = true;
    }
}