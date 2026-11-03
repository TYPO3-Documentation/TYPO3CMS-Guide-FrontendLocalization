..  include:: /Includes.rst.txt

..  _character-sets:

==============
Character sets
==============

TYPO3 websites use the UTF-8 character set. UTF-8 can store characters from all
languages. This means that TYPO3 websites in multiple languages do
not need any other character sets.

..  _character-sets-database:

The character set of the database
=================================

New installations on MySQL or MariaDB use the `utf8mb4` character set. This
character set can store UTF-8 characters (including emojis). The length of a text
field is based on the number of characters rather than the number of bytes, for
example, a :sql:`varchar(10)` field can store ten Chinese characters, even
though each character is three bytes long.

Some older installations may still use the `utf8` character set, which MySQL
calls `utf8mb3`. It stores characters of up to three bytes only, so it
cannot store emojis and some rare Chinese characters. To store them, convert
the database to `utf8mb4`.

New installations on MySQL or MariaDB use the `utf8mb4` character set. This
character set can store the entire UTF-8 character repertoire, including emojis.
The length of a text field is defined by the number of characters rather than
the number of bytes; for example, a :sql:varchar(10) field can store ten Chinese
characters, even though each character requires three bytes of storage. Some
older installations may still use the utf8 character set, which MySQL refers to
as utf8mb3. Because it only stores characters up to three bytes long, it cannot
support emojis or certain rare Chinese characters. To enable full character
support, convert the database to utf8mb4.

..  seealso::
    To set up the character set of your database, see:

    *   `MariaDB: Supported Character Sets and Collations <https://mariadb.com/kb/en/supported-character-sets-and-collations/>`__
    *   `MySQL: Unicode Support <https://dev.mysql.com/doc/refman/8.0/en/charset-unicode.html>`__
    *   `PostgreSQL: Character Set Support <https://www.postgresql.org/docs/current/multibyte.html>`__
