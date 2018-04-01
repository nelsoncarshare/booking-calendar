-- $CVSHeader: carshare/calendar/adodb/session/adodb-sessions.mysql.sql,v 1.1 2007/12/17 23:23:01 ian Exp $

CREATE DATABASE /*! IF NOT EXISTS */ adodb_sessions;

USE adodb_sessions;

DROP TABLE /*! IF EXISTS */ sessions;

CREATE TABLE /*! IF NOT EXISTS */ sessions (
	sesskey		CHAR(32)	/*! BINARY */ NOT NULL DEFAULT '',
	expiry		INT(11)		/*! UNSIGNED */ NOT NULL DEFAULT 0,
	expireref	VARCHAR(64)	DEFAULT '',
	data		LONGTEXT	DEFAULT '',
	PRIMARY KEY	(sesskey),
	INDEX expiry (expiry)
);
