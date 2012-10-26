.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


Web>List localization view
^^^^^^^^^^^^^^^^^^^^^^^^^^

In the Web>List module you can enable a localization view of the list
which will provide you with buttons for localization of records from
tables supporting localization:

|img-20|

The result is a view like this:

|img-21|

When a localization does not exist there will be an icon (“Localize
to”) to click which will localize the element.

The elements can be localized only to the alternative languages on the
page and since the page has only a Danish “Alternative Page Language”
record (named “Ikke-cached”) you see only Danish flags. Adding a
Russian translation will add Russian icons:

|img-22|


Technical note about “Localizations”
""""""""""""""""""""""""""""""""""""

The “Localize to” links presented by the Web>List module, Web>Page
module etc. uses the core “localize” command. This command creates a
copy of the default language record, changes the language setting to
the requested language and sets a reference back to the default
language original. Thus the localized version is bound to the original
giving the possibility of tracking translation precisely.

Behind this method there is an assumption that when localized elements
are selected and presented in the frontend of a website it is done
*by selecting the default language element subsequently being overlaid
with the alternative language record if found.* This means that all
queries and references between records should be done with the default
language records and localizations are just dumb overlays
automatically selected and shown if available. Not only is this a more
sound technical practice, it is also possible to take advantage of
inheritance of content from the default record; images, links,
references etc. - data that you might not like to enter a second time
for the localized record!

Taking advantage of overlays and inheritance is enabled by TypoScript
config options like “config.sys\_language\_overlay” and
“config.sys\_language\_softMergeIfNotBlank”

