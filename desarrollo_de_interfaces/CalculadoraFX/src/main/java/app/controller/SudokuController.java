package app.controller;

import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.layout.GridPane;
import javafx.scene.paint.Color;
import javafx.scene.text.Font;
import javafx.geometry.Pos;

import java.util.*;

public class SudokuController {

    @FXML private GridPane boardGrid;
    @FXML private Label statusLabel;

    private TextField[][] cells = new TextField[9][9];
    private int[][] solution = new int[9][9];
    private TextField selectedCell;

    @FXML
    private void initialize() {
        createGrid();
        generatePuzzle();
    }

    private void createGrid() {
        for (int row = 0; row < 9; row++) {
            for (int col = 0; col < 9; col++) {
                TextField tf = new TextField();
                tf.setPrefSize(50, 50);
                tf.setAlignment(Pos.CENTER);
                tf.setFont(Font.font(22));
                tf.setEditable(false);

                int r = row, c = col;
                tf.setOnMouseClicked(e -> selectCell(r, c));
                cells[row][col] = tf;
                boardGrid.add(tf, col, row);

                // Bordes gruesos para separar 3x3
                StringBuilder style = new StringBuilder("-fx-border-color: black; -fx-border-width: 1;");
                if ((col + 1) % 3 == 0) style.append(" -fx-border-right-width: 3;");
                if (col % 3 == 0) style.append(" -fx-border-left-width: 3;");
                if ((row + 1) % 3 == 0) style.append(" -fx-border-bottom-width: 3;");
                if (row % 3 == 0) style.append(" -fx-border-top-width: 3;");
                tf.setStyle(style.toString());
            }
        }
    }

    private void selectCell(int row, int col) {
        if (selectedCell != null) {
            selectedCell.setStyle(selectedCell.getStyle().replace("-fx-background-color: lightblue;", ""));
        }
        selectedCell = cells[row][col];
        if (!selectedCell.getStyleClass().contains("fixed")) {
            selectedCell.setStyle(selectedCell.getStyle() + "-fx-background-color: lightblue;");
        }
    }

    @FXML
    private void onNumberClick(javafx.event.ActionEvent e) {
        if (selectedCell == null) return;
        if (selectedCell.getStyleClass().contains("fixed")) return;

        String num = ((Button) e.getSource()).getText();
        selectedCell.setText(num);
    }

    @FXML
    private void onValidate() {
        boolean correct = true;
        for (int row = 0; row < 9; row++) {
            for (int col = 0; col < 9; col++) {
                String text = cells[row][col].getText();
                int val = text.isEmpty() ? 0 : Integer.parseInt(text);
                if (val != solution[row][col]) {
                    correct = false;
                    break;
                }
            }
        }
        if (correct) {
            statusLabel.setText("✅ Sudoku correcto!");
        } else {
            statusLabel.setText("❌ Sudoku incorrecto!");
        }
    }

    @FXML
    private void onNewPuzzle() {
        generatePuzzle();
        statusLabel.setText("");
    }

    private void generatePuzzle() {
        // Limpiar grid
        for (int i = 0; i < 9; i++)
            for (int j = 0; j < 9; j++) {
                cells[i][j].setText("");
                cells[i][j].getStyleClass().removeAll("fixed", "editable");
                // Reset color
                String style = cells[i][j].getStyle().replace("-fx-background-color: lightblue;", "");
                cells[i][j].setStyle(style);
            }

        generateFullSolution();

        // Colocar algunos números aleatorios (~25-30% de celdas)
        Random rand = new Random();
        for (int row = 0; row < 9; row++) {
            for (int col = 0; col < 9; col++) {
                if (rand.nextDouble() < 0.3) { // fijo
                    cells[row][col].setText(String.valueOf(solution[row][col]));
                    cells[row][col].getStyleClass().add("fixed");
                    cells[row][col].setStyle(cells[row][col].getStyle() + "-fx-background-color: #d3d3d3;"); // gris para fijos
                } else {
                    cells[row][col].getStyleClass().add("editable");
                    cells[row][col].setStyle(cells[row][col].getStyle() + "-fx-background-color: #7f8c8d; -fx-text-fill: white;"); // botón estilo calculadora
                }
            }
        }
    }

    // Genera solución completa con backtracking
    private boolean generateFullSolution() {
        solution = new int[9][9];
        return fill(0,0);
    }

    private boolean fill(int row, int col) {
        if (row == 9) return true;
        int nextRow = (col == 8) ? row + 1 : row;
        int nextCol = (col + 1) % 9;
        List<Integer> numbers = new ArrayList<>();
        for (int i = 1; i <= 9; i++) numbers.add(i);
        Collections.shuffle(numbers);

        for (int num : numbers) {
            if (isSafe(row, col, num)) {
                solution[row][col] = num;
                if (fill(nextRow, nextCol)) return true;
            }
        }
        solution[row][col] = 0;
        return false;
    }

    private boolean isSafe(int row, int col, int num) {
        for (int i = 0; i < 9; i++) {
            if (solution[row][i] == num) return false;
            if (solution[i][col] == num) return false;
        }
        int startRow = row/3*3, startCol = col/3*3;
        for (int i = 0; i <3; i++)
            for (int j=0;j<3;j++)
                if (solution[startRow+i][startCol+j] == num) return false;
        return true;
    }
}
