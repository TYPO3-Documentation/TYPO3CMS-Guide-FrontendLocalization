..  include:: /Includes.rst.txt

..  _character-sets:

==============
Character sets
==============

All TYPO3 websites use UTF-8 as their character set. UTF-8 can store every
character of every language, so a website in several languages needs no
other character set.

..  _character-sets-database:

The character set of the database
=================================

A new installation on MySQL or MariaDB uses the character set `utf8mb4`,
which stores every character of UTF-8, including emoji. The length of a text
field counts characters, not bytes. A field of the type :sql:`varchar(10)`
stores ten Chinese characters, although each of them takes three bytes.

An older installation can still use the character set `utf8`, which MySQL
also names `utf8mb3`. It stores characters of up to three bytes only, so it
cannot store emoji and some rare Chinese characters. To store them, convert
the database to `utf8mb4`.

..  seealso::
    To set up the character set of your database, see:

    *   `MariaDB: Supported Character Sets and Collations <https://mariadb.com/kb/en/supported-character-sets-and-collations/>`__
    *   `MySQL: Unicode Support <https://dev.mysql.com/doc/refman/8.0/en/charset-unicode.html>`__
    *   `PostgreSQL: Character Set Support <https://www.postgresql.org/docs/current/multibyte.html>`__
