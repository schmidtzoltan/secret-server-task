CREATE TABLE secrets (
  hash varchar(128) NOT NULL PRIMARY KEY,
  secretText text NOT NULL,
  createdAt datetime NOT NULL,
  expiresAt datetime NULL,
  remainingViews int(32) NOT NULL
);
