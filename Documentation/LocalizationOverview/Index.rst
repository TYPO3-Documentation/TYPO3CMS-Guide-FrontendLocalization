.. include:: /Includes.rst.txt


.. _localization-overview:

Localization overview
^^^^^^^^^^^^^^^^^^^^^

You can get a complete overview of the page tree and page
translations by using the **Web > Info** module and choosing
the "Localization Overview" function.

.. figure:: /Images/ManualScreenshots/InfoModule/LocalizationOverviewIntroductionPackage.png
   :alt: Localization Overview in Web > Info module

   Overview of existing translations in a blank Introduction Package

All the green entries show which languages each page is available in.
The gray areas mean that no translation is available but access to the
page specifying this language will be tolerated. It is also very quick
to create new translations from this module: use the checkboxes and hit
the "Create new translation headers" button.

.. figure:: /Images/ManualScreenshots/InfoModule/LocalizationOverviewMassTranslation.png
   :alt: Translating several pages at once

   Creating translations for a whole selection of pages at once


.. _localization-overview-hide-missing-translations:

Hiding pages if no translation exist
""""""""""""""""""""""""""""""""""""

If a translation of a page does not exist it will by default still
appear in the website menu when using that language. Here the
home page of the Introduction Package is in German (as can be seen
from the translate page title in :code:`<title>` tag), and all other
(untranslated) pages still appear in the menu, albeit in the default
language (English).

.. figure:: /Images/ManualScreenshots/Frontend/LocalizationOverviewDefaultLanguageFallback.png
   :alt: The menu with untranslated pages

   The German home page with untranslated pages appearing in the menu

This behaviour can be changed. Let's edit the "Customizing" page.
In the "Behaviour" tab, check the "Hide page if no translation for current
language exists":

.. figure:: /Images/ManualScreenshots/Record/LocalizationOverviewHideIfNoTranslation.png
   :alt: Hiding the page if not translated

   Hide the page if it is not translated

This is reflected in the *Localization Overview*:

.. figure:: /Images/ManualScreenshots/InfoModule/LocalizationOverviewTranslationHidden.png
   :alt: Hidden translation in the overview

   The Localization Overview reflects the change in visibility of the "Customizing" page

From this it is clear that when viewing the website in
German the "Customizing" page is not accessible. The menu
reflects this in the frontend.

.. figure:: /Images/ManualScreenshots/Frontend/LocalizationOverviewMenuWithHiddenUntranslatedPage.png
   :alt: Hidden translation in the menu

   The "Customizing" page does not appear in the menu anymore

Trying to access the "Customizing" page with directly with its id will
produce an error.

.. figure:: /Images/ManualScreenshots/Frontend/LocalizationOverviewTranslationError.png
   :alt: Missing translation generates error

   An error message indicates a missing translation


.. _localization-overview-hide-default-language:

Hiding default translation of pages
"""""""""""""""""""""""""""""""""""

If you want pages in *only* the alternative languages you must still
create a default language page in the page tree which simply acts as a
placeholder. Setting this status is done by selecting the checkbox
"Hide default translation of page":

.. figure:: /Images/ManualScreenshots/Record/LocalizationOverviewHideDefaultLanguage.png
   :alt: Hiding the page in default language

   Hide the page in the default language

This is reflected in the *Localization Overview*:

.. figure:: /Images/ManualScreenshots/Record/LocalizedContentAllLanguageDefined.png
   :alt: Hidden default language in the overview

   The Localization Overview shows the page as being unavailable in the default language

.. note::

   The page also appears as being unavailable in Danish, because Danish falls back to
   English and English is not available.

On the web site, the menu now looks like this in German:

.. figure:: /Images/ManualScreenshots/Frontend/LocalizationOverviewHideDefaultLanguageMenuGerman.png
   :alt: German menu with language-specific page

   The German-specific page shows up in the German version of the web site

and in English:

.. figure:: /Images/ManualScreenshots/Frontend/LocalizationOverviewHideDefaultLanguageMenuEnglish.png
   :alt: English menu not showing language-specific page

   The German-specific page does not show up in the default version of the web site

Trying to access the "Nur für Deutschland" page in default language will
yield an error.

Hiding pages in the default language is probably a rare thing to do,
but it is possible to imagine cases where the topic of a page or
section is only relevant in one of the alternative languages.
Especially if a language of the site is not only a translation but may
serve subsidiaries of a company in a local context.


.. _localization-overview-inverse-hiding:

Inverse control of hidden translations
""""""""""""""""""""""""""""""""""""""

It is also possible to hide all untranslated pages by default
with a global setting:

.. code-block:: php
   :caption: EXT:site_package/ext_localconf.php

   $GLOBALS['TYPO3_CONF_VARS']['FE']['hidePagesIfNotTranslatedByDefault'] = 1;

The *Localization Overview* reflects this immediately:

.. figure:: /Images/ManualScreenshots/InfoModule/LocalizationOverviewInvertTranslationHandling.png
   :alt: All untranslated pages hidden by default

   The Localization Overview shows that all untranslated pages are hidden by default

Note how the behaviour of specific localization setting for the
"Customizing" pages has been inverted. We had earlier defined the page
to be hidden if no translation existed. Now it is forced to display
even if no translation exists (this is reflected by its background
being gray instead of red).

When editing the page properties, the label of the corresponding
checkbox has changed:

.. figure:: /Images/ManualScreenshots/Frontend/LocalizationOverviewShowEvenIfNoTranslation.png
   :alt: Show page even if no translation exists

   Inverted behaviour: choose to show the page even if no translation exists


.. _localization-overview-final-notes:

Final notes
"""""""""""

Summary of colors in "Localization Overview":

Green background
  Page is translated and viewable in this
  language. For translations it means that an active Alternative Page
  Language overlay record is present.

Red background
  Page  *cannot* be viewed in this language and you
  will see an error message if you try. Menus should automatically
  filter out links to pages with this translation.

Gray background (not available for default language)
  Page will fall back to the specified fallback mode for content.
  Depends on language fallback configuration set in your site
  configuration.
