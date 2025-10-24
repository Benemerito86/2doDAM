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
    /// Lógica de interacción para AdminWindow.xaml
    /// </summary>
    public partial class AdminWindow : Window
    {
        public AdminWindow()
        {
            InitializeComponent();
        }

        public void ToProfile(object sender, RoutedEventArgs e)
        {
            var profile = new ProfileWindow("admin");
            profile.Show();
        }
        public void ToAddGame(object sender, RoutedEventArgs e)
        {
            var addGameWindow = new AddJuego();
            addGameWindow.Show();
        }
        public void ToDelGame(object sender, RoutedEventArgs e)
        {
            var delGame = new DelGame();
            delGame.Show();
        }


    }
}
