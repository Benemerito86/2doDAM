import sqlite3
import os

RUTA_BD = os.path.join(os.path.dirname(__file__), "juego.db")


def obtener_conexion():
    return sqlite3.connect(RUTA_BD)


def inicializar_bd():
    conexion = obtener_conexion()
    cursor = conexion.cursor()


    cursor.execute("""
        CREATE TABLE IF NOT EXISTS medios (
            id INTEGER PRIMARY KEY,
            titulo TEXT NOT NULL,
            pista1 TEXT,
            pista2 TEXT,
            pista3 TEXT,
            pista4 TEXT,
            pista5 TEXT
        )
    """)

    cursor.execute("""
        CREATE TABLE IF NOT EXISTS puntuaciones (
            id INTEGER PRIMARY KEY,
            nombre_usuario TEXT NOT NULL,
            puntuacion_final INTEGER,
            fecha_jugada TEXT
        )
    """)

    datos_ejemplo = [
        ("Inception",
         "Dirigida por Christopher Nolan.",
         "Trata sobre entrar en los sueños de otras personas.",
         "El protagonista es Cobb, interpretado por Leonardo DiCaprio.",
         "Usa un objeto llamado 'tótem' para distinguir la realidad.",
         "Termina con una escena ambigua sobre un trompo."),

        ("The Shawshank Redemption",
         "Es una película basada en una novela de Stephen King.",
         "Está ambientada en una prisión estatal de EE.UU.",
         "El protagonista es un banquero acusado injustamente.",
         "Su amigo más cercano se llama Red.",
         "La banda sonora incluye la ópera 'Duettino – Sull'aria'."),

        ("Game of Thrones",
         "Es una serie de fantasía épica basada en libros de George R.R. Martin.",
         "Incluye casas nobles luchando por el control de un reino.",
         "Una de sus frases más famosas es 'Winter is coming'.",
         "Tiene dragones y una amenaza del norte llamada 'Los Otros'.",
         "El Trono de Hierro es el símbolo del poder supremo."),

        ("Forrest Gump",
         "Protagonizada por Tom Hanks.",
         "El personaje principal tiene un coeficiente intelectual bajo pero un gran corazón.",
         "Recorre eventos históricos de EE.UU. sin darse cuenta.",
         "Famoso por la frase: 'La vida es como una caja de bombones'.",
         "Corre durante años sin rumbo fijo por todo el país."),

        ("The Office (US)",
         "Es una comedia de oficina grabada en estilo documental.",
         "Está ambientada en una empresa de papel de Scranton, Pensilvania.",
         "El jefe se llama Michael Scott y es muy excéntrico.",
         "Jim y Pam son una pareja icónica de la serie.",
         "Dwight Schrute es el vendedor estrella y fanático de las granjas de remolacha."),

        ("Interstellar",
         "Dirigida por Christopher Nolan.",
         "Trata sobre la búsqueda de un nuevo hogar para la humanidad.",
         "Involucra agujeros negros, relatividad y el amor como fuerza cuántica.",
         "La protagonista es una científica llamada Murph de adulta.",
         "El robot TARS tiene un diseño cuadrado y un sentido del humor sarcástico."),

        ("Friends",
         "Serie de comedia ambientada en Nueva York.",
         "Gira en torno a seis amigos que viven en Manhattan.",
         "Uno de ellos es un chef llamado Monica.",
         "Ross y Rachel tienen una relación amorosa complicada.",
         "El sofá naranja del Central Perk es un símbolo de la serie."),

        ("The Dark Knight",
         "Secuela de 'Batman Begins', dirigida por Christopher Nolan.",
         "El villano principal es el Joker, interpretado por Heath Ledger.",
         "Incluye una escena en un hospital con una explosión controlada.",
         "El personaje de Harvey Dent se convierte en Dos Caras.",
         "Frase icónica: 'Why so serious?'"),

        ("Parasite",
         "Película surcoreana ganadora del Óscar a Mejor Película.",
         "Trata sobre la desigualdad social entre dos familias.",
         "Una familia pobre se infiltra en la casa de una familia rica.",
         "Hay una escena con un pastel de cumpleaños y un ataque sorpresa.",
         "La lluvia intensa desencadena una catástrofe para los pobres."),

        ("The Mandalorian",
         "Serie de Star Wars en Disney+.",
         "Protagonizada por un cazarrecompensas con armadura beskar.",
         "Viaja con un niño pequeño de la misma especie que Yoda.",
         "El bebé se llama Grogu, aunque muchos lo llaman 'Baby Yoda'.",
         "La frase 'This is the Way' es un lema de los Mandalorianos."),

        ("Pulp Fiction",
         "Dirigida por Quentin Tarantino.",
         "Tiene una narrativa no lineal con varias historias entrelazadas.",
         "Incluye una escena con una hamburguesa 'Royale with Cheese'.",
         "John Travolta y Samuel L. Jackson interpretan a sicarios.",
         "La maleta misteriosa brilla con un contenido nunca mostrado."),

        ("Squid Game",
         "Serie surcoreana de supervivencia extrema.",
         "Participantes en deuda juegan juegos infantiles con apuestas mortales.",
         "Los guardias usan máscaras geométricas rojas.",
         "El número 456 es el del protagonista.",
         "El símbolo de los juegos es un círculo, un triángulo y un cuadrado."),

        ("La La Land",
         "Musical romántico protagonizado por Emma Stone y Ryan Gosling.",
         "Está ambientado en Los Ángeles y gira en torno al cine y el jazz.",
         "Empieza con una coreografía en una autopista.",
         "La protagonista audiciona varias veces antes de triunfar.",
         "El final alterna entre la realidad y un 'qué hubiera pasado'."),

        ("Black Mirror",
         "Serie antológica británica sobre tecnología y distopía.",
         "Cada episodio es independiente y muestra un futuro oscuro.",
         "Uno de los episodios más famosos involucra a un primer ministro y un cerdo.",
         "La tecnología siempre tiene consecuencias inesperadas y negativas.",
         "El título hace referencia a las pantallas apagadas que reflejan al espectador."),

        ("Avengers: Endgame",
         "Película de superhéroes de Marvel.",
         "Concluye la saga del Universo Cinematográfico de Marvel.",
         "Los héroes viajan en el tiempo para recuperar las Gemas del Infinito.",
         "Tony Stark sacrifica su vida para derrotar a Thanos.",
         "Frase final: 'I am Iron Man'."),

        ("The Godfather",
         "Clásico del cine dirigido por Francis Ford Coppola.",
         "Cuenta la historia de una familia mafiosa italiana en EE.UU.",
         "El patriarca se llama Vito Corleone.",
         "Su hijo Michael se convierte en el nuevo jefe de la familia.",
         "Famosa frase: 'I'm gonna make him an offer he can't refuse'."),

        ("Stranger Things",
         "Serie de ciencia ficción y terror de los años 80.",
         "Un niño desaparece en un pequeño pueblo de Indiana.",
         "Aparece una niña con poderes psíquicos llamada Eleven.",
         "El mundo paralelo se llama 'El Mundo del Revés'.",
         "La música de sintetizador es parte clave de su atmósfera."),

        ("Titanic",
         "Película romántica y de desastres dirigida por James Cameron.",
         "Se basa en el hundimiento real del RMS Titanic en 1912.",
         "Jack y Rose se conocen a bordo del barco.",
         "La canción principal es 'My Heart Will Go On' de Celine Dion.",
         "Jack muere congelado en el océano después del naufragio."),

        ("Breaking Bad",
         "Serie sobre un profesor de química que fabrica metanfetamina.",
         "El protagonista se llama Walter White.",
         "Su socio es Jesse Pinkman, un exalumno.",
         "Usa el alias 'Heisenberg'.",
         "La serie termina con una ametralladora en el maletero de un coche."),

        ("Up",
         "Película animada de Pixar.",
         "Un anciano ata miles de globos a su casa para volar.",
         "Viaja a Sudamérica en busca de una aventura prometida.",
         "Acompañado por un niño llamado Russell.",
         "La casa aterriza en las cataratas Paradise Falls.")
    ]

    cursor.executemany("""
        INSERT INTO medios (titulo, pista1, pista2, pista3, pista4, pista5)
        VALUES (?, ?, ?, ?, ?, ?)
    """, datos_ejemplo)

    conexion.commit()
    conexion.close()