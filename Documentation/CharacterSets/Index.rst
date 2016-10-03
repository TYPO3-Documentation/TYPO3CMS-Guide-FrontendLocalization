.. include:: ../Includes.txt


.. _character-sets:

Character sets
^^^^^^^^^^^^^^

All TYPO3 CMS websites use UTF-8 as their character set.
Using UTF-8 means you have a consistent data storage and can
store any glyph from any language without thinking more about
charsets.


.. _character-sets-frontend:

Charset in frontend (advanced)
""""""""""""""""""""""""""""""

UTF-8 is also be used in the frontend automatically and it is
recommended to use it. However it is possible to change charset
settings in TypoScript.

:ref:`config.metaCharset <t3tsref:setup-config-metacharset>`
defines the character set of the HTML output. If
this is set to another value than UTF-8, all content is converted
before output although internally processed in UTF-8. This is useful
for special cases like Japanese websites where they e.g. use "shift-jis"
for content delivery.

If :code:`config.metaCharset` is *not* UTF-8, GET / POST data *is* automatically
converted from :code:`config.metaCharset` to UTF-8.


.. _character-sets-database:

Database field lengths
""""""""""""""""""""""

The TYPO3 CMS Core is compatible with UTF-8.

You might however face the problem that the database field lengths of some
extensions must be extended. For example, each Chinese glyph takes three
bytes. So if a field is a varchar(10) and an author enters 10 Chinese
glyphs only the first 3 glyphs will be stored (since they take up 9 bytes).
UTF-8 is tricky in this respect because all ASCII chars take only 1 byte
while European special chars typically take up 2 and asian charsets take
up 3 - but some special glyphs could take even 5-6 bytes!

For more information on how to set up the database to
use UTF-8, please read here:

http://dev.mysql.com/doc/refman/5.7/en/charset-unicode.html

