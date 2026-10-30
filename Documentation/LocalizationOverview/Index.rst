..  include:: /Includes.rst.txt

..  _localization-overview:

=====================
Localization overview
=====================

..  contents::
    :local:


..  _localization-overview-introduction:

Introduction
============

..  versionchanged:: 14.0
    The main module :guilabel:`Web` has been renamed to :guilabel:`Content`,
    and the module :guilabel:`Info` to :guilabel:`Status`.
    See `Feature: #107628 - Improved backend module naming and structure <https://docs.typo3.org/permalink/changelog:feature-107628-1729026000>`_


The :guilabel:`Content > Status > Localization Overview` module shows the
page tree with the translations of each page. Choose :guilabel:`Infinite` in
:guilabel:`Depth` to see all levels of the page tree:

..  figure:: /Images/GeneratedScreenshots/LocalizationOverview/Overview.png
    :alt: The Localization Overview of a site in three languages
    :class: with-shadow

    The Localization Overview of the Camino site

A green cell shows that the page has a visible translation in the language
of its column. A cell without a color shows that the page has no translation
in this language. See
`Colors of the Localization Overview <https://docs.typo3.org/permalink/t3translate:localization-overview-final-notes>`_
for all colors.

To translate several pages at once, check the pages in the column of a
language. Then click :guilabel:`Create new translation headers` at the top of
the column:

..  figure:: /Images/GeneratedScreenshots/LocalizationOverview/CreateTranslations.png
    :alt: Two pages checked for new Spanish translations
    :class: with-shadow

    Creating the Spanish translations of two pages at once


..  _localization-overview-hide-missing-translations:

Hiding pages if no translation exists
=====================================

What a page without a translation does depends on the fallback type of the
language, see
`Localized content <https://docs.typo3.org/permalink/t3translate:localized-content>`_:

*   In a language with the fallback type `strict`, such as Arabic here, the
    page does not exist. The menus do not show it.
*   In a language with the fallback type `fallback`, such as Spanish here, the
    page shows in the default language. The menus show it as well.

..  figure:: /Images/GeneratedScreenshots/LocalizationOverview/MenuWithUntranslatedPage.png
    :alt: The Spanish menu with the FAQs, which have no Spanish translation
    :class: with-shadow

    The Spanish menu shows the untranslated FAQs

To hide a page in the languages that it has no translation in, edit its page
properties. On the :guilabel:`Language` tab, check
:guilabel:`Hide page if no translation for current language exists`:

..  figure:: /Images/GeneratedScreenshots/LocalizationOverview/HideIfNotTranslated.png
    :alt: The option Hide page if no translation for current language exists
    :class: with-shadow

    Hiding the FAQs in the languages that they have no translation in

The Localization Overview marks the page with **N**, and shows its languages
without a translation in red:

..  figure:: /Images/GeneratedScreenshots/LocalizationOverview/OverviewHidden.png
    :alt: The Localization Overview with the FAQs marked with N and in red
    :class: with-shadow

    The FAQs in the Localization Overview after the change

The Spanish menu does not show the page anymore:

..  figure:: /Images/GeneratedScreenshots/LocalizationOverview/MenuWithHiddenPage.png
    :alt: The Spanish menu without the FAQs
    :class: with-shadow

    The Spanish menu without the FAQs

A visitor who opens the address of the page in Spanish gets an error:

..  figure:: /Images/GeneratedScreenshots/LocalizationOverview/TranslationError.png
    :alt: Page Not Found, because the page is not available in Spanish
    :class: with-shadow

    The FAQs in Spanish cause an error now


..  _localization-overview-hide-default-language:

Hiding default translation of pages
===================================

A page that exists in other languages only still needs a page in the default
language, which serves as a placeholder. On the :guilabel:`Language` tab of
its page properties, check :guilabel:`Hide default language of page`:

..  figure:: /Images/GeneratedScreenshots/LocalizationOverview/HideDefaultLanguage.png
    :alt: The option Hide default language of page, checked
    :class: with-shadow

    Hiding the page in the default language

The Localization Overview marks the page with **D**, and shows its default
language in red:

..  figure:: /Images/GeneratedScreenshots/LocalizationOverview/OverviewHiddenDefault.png
    :alt: The Localization Overview with a page marked with D
    :class: with-shadow

    A page that exists in Arabic only

..  note::
    The page is not available in Spanish either, because Spanish falls back to
    English, and English is hidden.

A visitor who opens the address of the page in the default language gets an
error, like the one in the previous section.

Few pages need this. It suits a page whose topic matters in one language
only, for example when a language of the site serves the subsidiary of a
company in one country.


..  _localization-overview-inverse-hiding:

Inverse control of hidden translations
======================================

It is also possible to hide all untranslated pages by default
with a global setting:

..  code-block:: php
    :caption: EXT:my_sitepackage/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['FE']['hidePagesIfNotTranslatedByDefault'] = 1;

The setting inverts the option of the page properties. A page without the
option is now hidden in the languages that it has no translation in. The
Localization Overview marks it with **N**, and shows these languages in red.
A page with the option is shown even if it has no translation, and the
label of the option reads
:guilabel:`Show page even if no translation exists`.


..  _localization-overview-final-notes:

Colors of the Localization Overview
===================================

The colors of the Localization Overview mean the following:

Green
    The page is available in this language. In the column of a language
    other than the default language, the page has a translation that is
    not hidden.

Red
    The page is not available in this language. In the column of the
    default language, the page hides its default language. In the column of
    another language, the page has no visible translation, and is hidden
    without one.

No color
    The page has no visible translation in this language. Whether it shows
    depends on the fallback type of the language in the site configuration.

Yellow
    The page has more than one translation in this language, which is an
    error.
