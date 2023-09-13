..  include:: /Includes.rst.txt

..  _character-sets:

==============
Character sets
==============

All TYPO3 websites use UTF-8 as their character set. Using UTF-8 means that you
have a consistent data storage and can store any glyph from any language without
worrying further about character sets.

..  _character-sets-database:

Database field lengths
======================

The TYPO3 Core is compatible with UTF-8.

However, you might face the problem that the database field lengths of some
extensions need to be extended. For example, each Chinese glyph takes three
bytes. So if a field is a :sql:`varchar(10)` and an author enters 10 Chinese
glyphs, only the first 3 glyphs will be stored (as they require 9 bytes). UTF-8
is tricky in this respect, as all ASCII characters only need 1 byte, while
European special characters usually need 2 and Asian character sets 3 bytes -
but some special characters can even need 5-6 bytes!

..  seealso::
    For more information on how to set up your database to use UTF-8, please
    read here:

    *   `MariaDB: Supported Character Sets and Collations <https://mariadb.com/kb/en/supported-character-sets-and-collations/>`__
    *   `MySQL: Unicode Support <https://dev.mysql.com/doc/refman/8.0/en/charset-unicode.html>`__
    *   `PostgreSQL: Character Set Support <https://www.postgresql.org/docs/current/multibyte.html>`__
