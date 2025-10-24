using System.Configuration;
using System.Data;
using System.Windows;
using WpfAppNoSteam.Database;

namespace WpfAppNoSteam
{
    public partial class App : Application
    {
        protected override void OnStartup(StartupEventArgs e)
        {
            base.OnStartup(e);

            // 🔋 ¡Importante! Inicializa SQLite
            SQLitePCL.Batteries.Init();

            // Aquí va tu lógica de base de datos
            DatabaseHelper.InitializeDatabase();

            new LoginWindow().Show();
        }
    }

}
