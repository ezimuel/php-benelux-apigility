CREATE TABLE speakers (
  id INTEGER PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  title VARCHAR(80),
  company VARCHAR(80),
  url VARCHAR(255),
  twitter VARCHAR(80)
);

CREATE TABLE talks (
  id INTEGER PRIMARY KEY,
  title TEXT,
  abstract TEXT,
  day TEXT,
  start_time TEXT,
  end_time TEXT
);

CREATE TABLE talks_speakers (
  talk_id INTEGER NOT NULL,
  speaker_id INTEGER NOT NULL
);
