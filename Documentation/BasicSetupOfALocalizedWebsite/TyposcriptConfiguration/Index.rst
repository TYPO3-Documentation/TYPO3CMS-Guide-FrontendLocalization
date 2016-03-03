.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


TypoScript configuration
^^^^^^^^^^^^^^^^^^^^^^^^

In your TypoScript template you will want to have a configuration of
localization which looks something like this::

   # Localization:
   config {
      linkVars = L
   }
   [globalVar = GP:L=1]
   config {
      sys_language_uid = 1
      language = dk
      locale_all = da_DK
      metaCharset = iso-8859-1
    }
   [globalVar = GP:L=2]
   config {
      sys_language_uid = 2
      language = ru
   }
   [global]


The "&L" variable
"""""""""""""""""

Although it is not a requirement to use the L variable for
localization it is highly recommended because it has been hardcoded a
large number of places to hold the uid of the sys\_language record
(menus / realurl / Page module / Preview links / etc.).

The lines 1-3 configures that if the GET request variable "&L=X" is
found it should be passed on to all generated links.

Lines 4 and 11 are conditions which tell that if the GET variable "L"
is 1 or 2 the system language (config.sys\_language\_uid) is set
accordingly (plus all other TypoScript template related settings you
might want to change for a localization). Also those conditions are
the reason that caching will support and recognize a change in the
L-parameter.

Setting up the L variable like this is the minimum requirement to make
language switching work.


config.language
"""""""""""""""

(line 7 and 14) Setting this configures the system "language key" to
be used for the language. This is used to select labels from XLF
files. Setting this should make frontend plugins
respond by showing labels from the correct language (requires
installation of the corresponding translations).


config.locale\_all
""""""""""""""""""

(line 8) Configures the locale which influences how some values from
PHP is formatted in the output, e.g. dates formatted using strftime()
which will then output month/day names in that language.


config.metaCharset
""""""""""""""""""

(line 9) Setting the output charset of the page to "iso-8859-1". Means
that content internally rendered in utf-8 is converted to "iso-8859-1"
before output:

|img-23|

For default and Russian language:

|img-24|

Even if "config.metaCharset" was set to "iso-8859-1" for Russian, the
output would be correct since HTML-entities would be used for glyphs
which cannot be represented in the chosen language:


utf-8 (default):
~~~~~~~~~~~~~~~~


|img-25|


iso-8859-1:
~~~~~~~~~~~

|img-26|

