CREATE DATABASE music;
USE music;

CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(45) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (user_id)
);

INSERT INTO users (username, email, password) VALUES
('music_lover', 'lover@example.com', '$2y$10$oiVIyJuno5P/9E.DDB9.eOq0a9yJ6khOziieTQr.kmT8.7dL5yPCq'),
('dj_master', 'dj@example.com', '$2y$10$9nkfOvztJTwAigIJESxBmul1q.Aag3JXBM52ftPvRQPNBL1bzddMq'),
('rock_fan', 'rock@example.com', '$2y$10$yeys4mM1vYgOpQB65gz.SO2OcHFJyCswlAovQCsrjWFWgmuo4BJc6');

CREATE TABLE music (
  music_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  artist VARCHAR(100) NOT NULL,
  genre VARCHAR(50) NOT NULL,
  duration TIME NOT NULL,
  PRIMARY KEY (music_id)
);

INSERT INTO music (name, artist, genre, duration) VALUES
('Shape of You', 'Ed Sheeran', 'Pop', '00:03:53'),
('Bohemian Rhapsody', 'Queen', 'Rock', '00:05:55'),
('Lose Yourself', 'Eminem', 'Hip-Hop', '00:05:26'),
('Billie Jean', 'Michael Jackson', 'Pop', '00:04:54'),
('Blinding Lights', 'The Weeknd', 'R&B', '00:03:20'),
('Smells Like Teen Spirit', 'Nirvana', 'Rock', '00:05:01'),
('Rolling in the Deep', 'Adele', 'Pop', '00:03:48'),
('Seven Nation Army', 'The White Stripes', 'Rock', '00:03:52'),
('Sicko Mode', 'Travis Scott', 'Hip-Hop', '00:05:12'),
('Uptown Funk', 'Mark Ronson ft. Bruno Mars', 'Funk', '00:04:30'),
('HUMBLE.', 'Kendrick Lamar', 'Hip-Hop', '00:02:57'),
('Take Me to Church', 'Hozier', 'Indie', '00:04:01'),
('Old Town Road', 'Lil Nas X', 'Country-Rap', '00:02:37'),
('Radioactive', 'Imagine Dragons', 'Alternative Rock', '00:03:06'),
('God s Plan', 'Drake', 'Hip-Hop', '00:03:18'),
('Starboy', 'The Weeknd ft. Daft Punk', 'R&B', '00:03:50'),
('Toxic', 'Britney Spears', 'Pop', '00:03:19'),
('Sweet Child O Mine', 'Guns N Roses', 'Rock', '00:05:56'),
('Thriller', 'Michael Jackson', 'Pop', '00:05:57'),
('Staying Alive', 'Bee Gees', 'Disco', '00:04:43');


CREATE TABLE favorite_songs (
  favorite_id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  music_id INT NOT NULL,
  PRIMARY KEY (favorite_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
  FOREIGN KEY (music_id) REFERENCES music(music_id) ON DELETE CASCADE
);

INSERT INTO favorite_songs (user_id, music_id) VALUES
(1, 2), (1, 5), (1, 8), (1, 14), (1, 20),
(2, 3), (2, 6), (2, 9), (2, 15), (2, 17),
(3, 1), (3, 4), (3, 7), (3, 10), (3, 12), (3, 18);


