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
    /// Lógica de interacción para LoginWindow.xaml
    /// </summary>
    public partial class LoginWindow : Window
    {
        public LoginWindow()
        {
            InitializeComponent();
        }
        public void Login_Click(object sender, RoutedEventArgs e)
        {
            UsuarioController usuarioController = new UsuarioController();
            bool exito = usuarioController.LoginUsuario(txtEmail.Text, txtPassword.Password);
            if (!exito)
            {
                MessageBox.Show("Error al iniciar sesión. Credenciales inválidas.", "Error", MessageBoxButton.OK, MessageBoxImage.Error);
                return;
            }
            else {                 
                MessageBox.Show("Inicio de sesión exitoso.", "Éxito", MessageBoxButton.OK, MessageBoxImage.Information);

                if (txtEmail.Text == "admin")
                {
                    AdminWindow adminWindow = new AdminWindow();
                    adminWindow.Show();
                    this.Close();
                    return;
                }

                MainWindow mainWindow = new MainWindow(txtEmail.Text);
                mainWindow.Show();
                this.Close();


            }
        }
        public void Register(object sender, RoutedEventArgs e)
        {
            RegisterWindow registerWindow = new RegisterWindow();
            registerWindow.Show();
            this.Close();
        }

    }
}
