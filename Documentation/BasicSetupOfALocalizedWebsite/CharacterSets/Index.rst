

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Character sets
^^^^^^^^^^^^^^

Recommended for all new TYPO3 websites is to set the global character
set to UTF-8. This is done by putting a line like this into the
localconf.php file of the site:

::

   $TYPO3_CONF_VARS['BE']['forceCharset'] = 'utf-8';


Explanation of “forceCharset”
"""""""""""""""""""""""""""""

The reason is that without a value for “forceCharset” the backend will
use a charset depending on the backend language of the user. So lets
say User A has a backend in Russian and User B a backend in Danish,
then User A will enter data in the charset “windows-1251” and User B
in “iso-8859-1”. Since data stored in TYPO3 is not tagged with a
charset this will lead to an inconsistent database.

If $TYPO3\_CONF\_VARS['BE']['forceCharset']is set, the same charset is
used for all users in the backend regardless of their backend language
and you will get consistent data in your database. But since
“iso-8859-1” and “windows-1251” are “incompatible” charsets (using the
same byte values for different glyphs) you will have to choose “utf-8”
as charset since that can contain both danish and russian chars - and
all other charsets of the world.

**Conclusion:** Using utf-8 means you have a consistent data storage
and can store any glyph from any language without thinking more about
charsets.

**Note:** $TYPO3\_CONF\_VARS['BE']['forceCharset']is not set by
default for backwards compatibility reasons but is recommended for all
new TYPO3 projects.


Charset in frontend (advanced)
""""""""""""""""""""""""""""""

The “forceCharset” value will also be used in the frontend
automatically. But it is possible to change charset settings in
TypoScript. There are two settings, “config.renderCharset” (don't
change unless you know what you are doing) and “config.metaCharset”.

config.metaCharset defines the character set of the HTML output. If
this is set to another value than renderCharset / forceCharset, all
content is converted before output although internally processed in
“renderCharset”. This is useful for special cases like japanese
websites where they like “shift-jis” used for content delivery.

If config.renderCharset != config.metaCharset there are a few things
to be aware of:

- Content from “PHP\_SCRIPT\_EXT” is  *not* converted! (everything else
  is, including USER\_INT)

- GET / POST data  *is* automatically converted from metaCharset to
  renderCharset


Database field lengths
""""""""""""""""""""""

If you choose to use  *utf-8* as charset you might face the problem
that the database field lengths must be extended. For example, each
chinese glyph takes three bytes. So if a field is a varchar(10) and an
author enters 10 chinese glyphs only the first 3 glyphs will be stored
(since they take up 9 bytes). utf-8 is tricky in this respect because
all ascii chars take only 1 byte while european special chars
typically take up 2 and asian charsets take up 3 - but some special
glyphs could take even 5-6 bytes!

If you are using  **MySQL 4.1** or above you can set the database to
use UTF-8. Please read more here:

http://dev.mysql.com/doc/refman/4.1/en/charset-unicode.html

If you are  *not* using MySQL (or any other DB) that supports UTF-8
you have to consider this workaround:

As long as a database does not support utf-8 so varchar(10) means
“store 10 utf-8 characters regardless of byte length” we offer a
setting in TYPO3 which takes care of it:

$TYPO3\_CONF\_VARS['SYS']['multiplyDBfieldSize'] = '3';

This setting will automatically change all varchar(10) fields to
“varchar(30)”. After changing this setting you must use the Install
Tool, “Database Analyzer” to alter all fields in tables.

