using Microsoft.Win32;
using System;
using System.IO;
using System.Windows;
using System.Windows.Input;
using WpfAppNoSteam.Controllers;

namespace WpfAppNoSteam
{
    public partial class AddJuego : Window
    {
        private string _droppedImagePath = null;

        public AddJuego()
        {
            InitializeComponent();
        }

        private void Grid_DragOver(object sender, DragEventArgs e)
        {
            if (e.Data.GetDataPresent(DataFormats.FileDrop))
            {
                string[] files = (string[])e.Data.GetData(DataFormats.FileDrop);
                if (files.Length == 1 && Path.GetExtension(files[0]).Equals(".png", StringComparison.OrdinalIgnoreCase))
                {
                    e.Effects = DragDropEffects.Copy;
                    return;
                }
            }
            e.Effects = DragDropEffects.None;
        }

        private void Grid_Drop(object sender, DragEventArgs e)
        {
            if (e.Data.GetDataPresent(DataFormats.FileDrop))
            {
                string[] files = (string[])e.Data.GetData(DataFormats.FileDrop);
                if (files.Length == 1)
                {
                    string filePath = files[0];
                    if (Path.GetExtension(filePath).Equals(".png", StringComparison.OrdinalIgnoreCase))
                    {
                        _droppedImagePath = filePath;
                        DropText.Text = $"Imagen seleccionada:\n{Path.GetFileName(filePath)}";
                        DropArea.Background = System.Windows.Media.Brushes.DarkGreen;
                    }
                    else
                    {
                        MessageBox.Show("Solo se permiten archivos PNG.", "Formato no válido", MessageBoxButton.OK, MessageBoxImage.Warning);
                    }
                }
            }
        }

        private void Add_Click(object sender, RoutedEventArgs e)
        {
            string nombre = txtNombre.Text?.Trim();
            string precioStr = txtPrecio.Text?.Trim();

            if (string.IsNullOrWhiteSpace(nombre))
            {
                MessageBox.Show("Por favor, introduce el nombre del juego.", "Nombre requerido", MessageBoxButton.OK, MessageBoxImage.Warning);
                return;
            }

            if (string.IsNullOrWhiteSpace(precioStr) || !decimal.TryParse(precioStr, out decimal precio))
            {
                MessageBox.Show("Por favor, introduce un precio válido.", "Precio inválido", MessageBoxButton.OK, MessageBoxImage.Warning);
                return;
            }

            if (_droppedImagePath == null)
            {
                MessageBox.Show("Arrastra una imagen PNG para el juego.", "Imagen requerida", MessageBoxButton.OK, MessageBoxImage.Warning);
                return;
            }

            try
            {
                // Carpeta donde guardar las imágenes (por ejemplo, /Images/)
                string imagesFolder = Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "assets/img");
                Directory.CreateDirectory(imagesFolder); // Crea la carpeta si no existe

                // Nombre seguro para archivo (sin caracteres inválidos)
                string safeName = string.Join("_", nombre.Split(Path.GetInvalidFileNameChars(), StringSplitOptions.RemoveEmptyEntries));
                string newImagePath = Path.Combine(imagesFolder, $"{safeName}.png");

                // Copiar y renombrar la imagen
                File.Copy(_droppedImagePath, newImagePath, overwrite: true);

                JuegoController juegoController = new JuegoController();
                juegoController.AddJuego(nombre, precio);

                MessageBox.Show($"Juego '{nombre}' añadido correctamente.\nImagen guardada como: {safeName}.png", "Éxito", MessageBoxButton.OK, MessageBoxImage.Information);


                txtNombre.Clear();
                txtPrecio.Clear();
                _droppedImagePath = null;
                DropText.Text = "Arrastra aquí una imagen PNG del juego";
                DropArea.Background = new System.Windows.Media.SolidColorBrush(System.Windows.Media.Color.FromRgb(0x2A, 0x2A, 0x2A));
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Error al guardar la imagen: {ex.Message}", "Error", MessageBoxButton.OK, MessageBoxImage.Error);
            }
        }
    }
}