// MainWindow.xaml.cs
using System.Windows;
using WpfAppNoSteam.Controllers;
using WpfAppNoSteam.Models;

namespace WpfAppNoSteam
{
    public partial class MainWindow : Window
    {
        private readonly string _emailLogueado;

        public MainWindow(string email)
        {
            InitializeComponent();
            _emailLogueado = email;
            CargarJuegos(); // ← carga al iniciar
        }

        private void CargarJuegos()
        {
            var controller = new JuegoController();
            ListaJuegos.ItemsSource = controller.ObtenerJuegosConEstadoUsuario(_emailLogueado);
        }

        // Haz clic en un juego para añadirlo al carrito
        private void Juego_Click(object sender, RoutedEventArgs e)
        {
            if (sender is System.Windows.Controls.Button button &&
                button.Tag is Juego juego)
            {
                var controller = new JuegoController();
                controller.ActualizarEstadoJuego(_emailLogueado, juego.Id, "carrito");

                MessageBox.Show($"'{juego.Nombre}' añadido al carrito.");
                CargarJuegos(); // recarga para actualizar el estado visualmente
                
            }
        }

        private void ToProfile(object sender, RoutedEventArgs e)
        {
            var profile = new ProfileWindow(_emailLogueado);
            profile.Show();
        }
        private void ToCarrito(object sender, RoutedEventArgs e)
        {
            var carritoWindow = new CarritoWindow(_emailLogueado);
            carritoWindow.Show();
        }
    }
}