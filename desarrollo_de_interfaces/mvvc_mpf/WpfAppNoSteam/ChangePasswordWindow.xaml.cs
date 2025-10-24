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
using WpfAppNoSteam.Controllers;

namespace WpfAppNoSteam
{
    /// <summary>
    /// Lógica de interacción para ChangePasswordWindow.xaml
    /// </summary>
    public partial class ChangePasswordWindow : Window
    {
        private readonly string _emailUsuario;
        public ChangePasswordWindow(string email)
        {
            InitializeComponent();
            _emailUsuario = email;
        }
        private void btnChangePassword_Click(object sender, RoutedEventArgs e)
        {
            string nueva = txtNewPassword.Password;
            string confirm = txtConfirmPassword.Password;

            if (string.IsNullOrWhiteSpace(nueva) || string.IsNullOrWhiteSpace(confirm))
            {
                MessageBox.Show("Por favor, completa ambos campos.", "Error", MessageBoxButton.OK, MessageBoxImage.Warning);
                return;
            }

            if (nueva != confirm)
            {
                MessageBox.Show("Las contraseñas no coinciden.", "Error", MessageBoxButton.OK, MessageBoxImage.Error);
                return;
            }

            var controller = new UsuarioController();
            if (controller.CambiarContraseña(_emailUsuario, nueva))
            {
                MessageBox.Show("¡Contraseña actualizada con éxito!", "Éxito", MessageBoxButton.OK, MessageBoxImage.Information);
                this.Close();
            }
            else
            {
                MessageBox.Show("No se pudo actualizar la contraseña. Inténtalo de nuevo.", "Error", MessageBoxButton.OK, MessageBoxImage.Error);
            }
        }
    }
}
