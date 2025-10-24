using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;

namespace WpfAppNoSteam
{
    /// <summary>
    /// Lógica de interacción para ProfileWindow.xaml
    /// </summary>
    public partial class ProfileWindow : Window
    {
        private string _emailUsuario;

        // Constructor que recibe el email del usuario logueado
        public ProfileWindow(string email)
        {
            InitializeComponent();
            _emailUsuario = email;
            txtEmailDisplay.Text = $"Sesión: {email}";
        }

        private void btnCambiarPass_Click(object sender, RoutedEventArgs e)
        {
            // Aquí abrirías una ventana de "Cambiar Contraseña"
            ChangePasswordWindow changePasswordWindow = new ChangePasswordWindow(_emailUsuario);
            changePasswordWindow.ShowDialog();

        }

        private void btnCerrarSesion_Click(object sender, RoutedEventArgs e)
        {
            // Cierra esta ventana y vuelve al login
            var loginWindow = new LoginWindow();
            loginWindow.Show();
            this.Close();

            // Opcional: si usas MainWindow, ciérrala también
            foreach (Window window in Application.Current.Windows)
            {
                if (window is MainWindow)
                {
                    window.Close();
                }
            }
        }
    }
}
