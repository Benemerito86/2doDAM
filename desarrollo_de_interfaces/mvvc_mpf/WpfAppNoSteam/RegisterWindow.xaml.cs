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
    /// Lógica de interacción para RegisterWindow.xaml
    /// </summary>
    public partial class RegisterWindow : Window
    {
        public RegisterWindow()
        {
            InitializeComponent();
        }
        public void Register_Click(object sender, RoutedEventArgs e)
        {
            UsuarioController usuarioController = new UsuarioController();
            bool exito = usuarioController.RegistrarUsuario(txtEmail.Text, txtPassword.Password);
            if (exito)
            {
                MessageBox.Show("Registro exitoso. Ahora puedes iniciar sesión.", "Éxito", MessageBoxButton.OK, MessageBoxImage.Information);

                LoginWindow loginWindow = new LoginWindow();
                loginWindow.Show();
                this.Close();
            }
            else
            {
                MessageBox.Show("Error al registrar el usuario. El correo electrónico ya existe o los datos son inválidos.", "Error", MessageBoxButton.OK, MessageBoxImage.Error);
                return;
            }

        }
        public void Login(object sender, RoutedEventArgs e)
        {
            LoginWindow loginWindow = new LoginWindow();
            loginWindow.Show();
            this.Close();
        }
    }
}
