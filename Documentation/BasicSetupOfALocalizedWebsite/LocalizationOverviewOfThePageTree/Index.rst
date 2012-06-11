.. include:: Images.txt

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


Localization Overview of the page tree
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

|img-9| You can get a complete overview of the page tree and according
translations by using the Web>Info module, choosing the function menu
item “Localization Overview”:

All the green entries show which languages each page is available in.
The gray areas means no translation is available but access to the
page specifying this language will be tolerated. It is also very quick
to create new translations from this module (using the check boxes).


Hiding pages if no translation exist
""""""""""""""""""""""""""""""""""""

If a translation of a page does not exist it will by default still
appear in the website menu when using that language. Here the
“Contact” page is still shown with default, English content:

|img-10| If you check the “Hide page if no translation for current
language exists” checkbox for the “Contact” page in “page properties”
you can avoid this:

|img-11|

This will be reflected in the Localization Overview:

|img-12| From this it is clear that when viewing the website in
Russian the “Contact” page is not accessible. And the menu will
reflect this since now the “Contact” page is not shown.

|img-13| Trying to access the “Contact” page with the id will even
show an error.


Hiding default translation of pages
"""""""""""""""""""""""""""""""""""

If you want pages in  *only* the alternative languages you must still
create a default language page in the page tree which simply acts as a
placeholder. Setting this status is done by selecting the checkbox
“Hide default translation of page”:

|img-14| This is reflected like this in the Localization Overview:

|img-15| On the website it will look like this:

Danish:

|img-16|

English:

|img-17| Trying to access the page “Visioner” in default language will
yield an error.

Hiding pages in the default language is probably a rare thing to do,
but it is possible to imagine cases where the topic of a page or
section is only relevant in one of the alternative languages.
Especially if a language of the site is not only a translation but may
serve subsidiaries of a company in a local context.


Inverse control of hidden translations
""""""""""""""""""""""""""""""""""""""

If you prefer that all pages are hidden by default (reverse action of
the “Localization Settings” check boxes) you can set a
TYPO3\_CONF\_VARS option:

::

   $TYPO3_CONF_VARS['FE']['hidePagesIfNotTranslatedByDefault'] = '1';

The Localization Overview will reflect this immediately:

|img-18|

Notice, that the Localization Setting checkbox is reversed for the
“Contact” page (the background above is gray, not red):

|img-19|


Final notes
"""""""""""

Summary of colors in “Localization Overview”:

- **Green background:** Page is translated and viewable in this
  language. For translations it means that an active Alternative Page
  Language overlay record is present (“Alternative Page Language” in
  Web>List module).

- **Red background:** Page  *cannot* be viewed in this language and you
  will see an error message if you try. Menus should automatically
  filter out links to pages with this translation.

- **Gray background** (not available for default language): Page will
  fall back to the specified fallback mode for content. Depends on
  configuration of “config.sys\_language\_mode” in your TypoScript
  Template. More information below.

**Notice about possibly false menu items when “Localization settings”
are used:**

When running in default fallback mode (config.sys\_language\_mode =
0/blank/not set) menu generation may create false items because
sys\_language\_uid will be different from the value set by the &L
parameter (which the menu will just pass through not knowing what it
does) when a page translation is not found. Menu items not available
in the default language will not be shown even if they should and
items which are not available in the translation will be shown
regardless of this.

Solution is to configure in TypoScript "config.sys\_language\_mode =
content\_fallback" because it will keep the “sys\_language\_uid” value
according to that defined by &L regardless of whether a translation
exists or not.

If you wish not to use “config.sys\_language\_mode =
content\_fallback” you can also choose to set the property
“protectLvar” for the HMENU objects; this will correct the L-variable
for those menu items which are not available. See TSref for details
about that option.

