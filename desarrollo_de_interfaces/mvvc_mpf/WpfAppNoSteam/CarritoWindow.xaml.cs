using System.Collections.Generic;
using System.Windows;
using WpfAppNoSteam.Controllers;
using WpfAppNoSteam.Models;

namespace WpfAppNoSteam
{
    public partial class CarritoWindow : Window
    {
        private readonly string _emailUsuario;
        private readonly JuegoController _controller;

        public CarritoWindow(string email)
        {
            InitializeComponent();
            _emailUsuario = email;
            _controller = new JuegoController();
            CargarCarrito();
        }

        private void CargarCarrito()
        {
            var juegosEnCarrito = _controller.ObtenerJuegosPorEstado(_emailUsuario, "carrito");

            if (juegosEnCarrito.Count == 0)
            {
                ListaCarrito.Visibility = Visibility.Collapsed;
                txtVacio.Visibility = Visibility.Visible;
            }
            else
            {
                ListaCarrito.ItemsSource = juegosEnCarrito;
                txtVacio.Visibility = Visibility.Collapsed;
            }
        }

        private void Comprar_Click(object sender, RoutedEventArgs e)
        {
            if (sender is System.Windows.Controls.Button button &&
                button.Tag is Juego juego)
            {
                _controller.ActualizarEstadoJuego(_emailUsuario, juego.Id, "comprado");
                MessageBox.Show($"¡Has comprado {juego.Nombre}!", "Éxito",
                    MessageBoxButton.OK, MessageBoxImage.Information);
                CargarCarrito(); // Actualiza el carrito
            }
        }
        private void ComprarTodo_Click(object sender, RoutedEventArgs e)
        {
            List<Juego> juegosEnCarrito = _controller.ObtenerJuegosPorEstado(_emailUsuario, "carrito");
            foreach (var juego in juegosEnCarrito)
            {
                _controller.ActualizarEstadoJuego(_emailUsuario, juego.Id, "comprado");
            }
            MessageBox.Show("¡Has comprado todos los juegos en el carrito!", "Éxito",
                MessageBoxButton.OK, MessageBoxImage.Information);
            CargarCarrito(); // Actualiza el carrito
        }
        private void Vaciar_Click(object sender, RoutedEventArgs e)
        {
            if (sender is System.Windows.Controls.Button button &&
                button.Tag is Juego juego)
            {
                _controller.ActualizarEstadoJuego(_emailUsuario, juego.Id, "venta");
                MessageBox.Show($"{juego.Nombre} ha sido eliminado del carrito.", "Éxito",
                    MessageBoxButton.OK, MessageBoxImage.Information);
                CargarCarrito(); // Actualiza el carrito
            }
        }
        private void VaciarTodo_Click(object sender, RoutedEventArgs e)
        {
            List<Juego> juegosEnCarrito = _controller.ObtenerJuegosPorEstado(_emailUsuario, "carrito");
            foreach (var juego in juegosEnCarrito)
            {
                _controller.ActualizarEstadoJuego(_emailUsuario, juego.Id, "venta");
            }
            MessageBox.Show("El carrito ha sido vaciado.", "Éxito",
                MessageBoxButton.OK, MessageBoxImage.Information);
            CargarCarrito(); // Actualiza el carrito
        }
    }
}