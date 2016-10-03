.. include:: ../Includes.txt


.. _languages:

Setting up languages
^^^^^^^^^^^^^^^^^^^^

Each language into which you want your web site to be translated
must be defined explicitely. These come in addition to the so-called
"default" language. That default language is whatever you decide it
to be.

The system languages are added on the root level of the page tree.
The Introduction Package comes with Danish and German predefined.

.. figure:: ../Images/SystemLanguages.png
   :alt: List of system languages

   Viewing the list of system languages

The record for the Danish language record looks like this:

.. figure:: ../Images/SystemLanguageDetail.png
   :alt: Details of a system languages

   Input form for a system language

Once you have defined at least one system language,
you have the option of translating pages and content.
For example, the **Web > List** module will show links
for translating, provided you have translated the page
and checked the "Localization view" at the bottom of
the scren.

.. figure:: ../Images/LocalizeLinks.png
   :alt: Content elements with localize links

   The Web > List view, with page translations and localize links for content elements

Translated elements appears nested "under" their default language
parent element in the **Web > List** view.

.. figure:: ../Images/NestedTranslations.png
   :alt: Nested translations

   The Web > List view shows translations nested under their parent


.. _technical-note:

Technical note about "Localizations"
""""""""""""""""""""""""""""""""""""

The "Localize to" links presented by the Web>List module, Web>Page
module etc. uses the core "localize" command. This command creates a
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
config options like "config.sys\_language\_overlay" and
"config.sys\_language\_softMergeIfNotBlank"

