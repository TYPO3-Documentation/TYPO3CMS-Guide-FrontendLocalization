..  include:: /Includes.rst.txt

..  _localized-content:

=================
Localized content
=================

..  contents::
    :local:


..  _localized-content-introduction:

Introduction
============

There are two ways to translate the content of a page:

Connected mode
    A translation stays connected to its original in the default language.
    It points to the original in the field that
    `transOrigPointerField <https://docs.typo3.org/permalink/t3translate:core-support-tca-transorigpointerfield>`_
    names, which is `l18n_parent` in the table `tt_content`. The translation
    takes its type and its column from the original. When you move the
    original, TYPO3 moves its translations with it. In the frontend, TYPO3
    shows a translation only where it shows the original. Use this mode for
    a translation that follows the original closely.

Free mode
    A copy is a record of its own in the target language, with no
    connection to the original. You can move, change, and delete it
    without affecting the original, but you cannot compare it with the
    changes that the original gets later. Use this mode when the content of
    a language differs a lot from the content of the default language.

When you translate a page or a content element, the translation wizard asks
for this choice in its step **Mode**, see
`Translating pages <https://docs.typo3.org/permalink/t3translate:page-translations>`_:

..  figure:: /Images/GeneratedScreenshots/LocalizedContent/TranslationMode.png
    :alt: The step Mode of the translation wizard with Translate and Copy
    :class: with-shadow

    The translation wizard asks whether to translate or to copy the content

:guilabel:`Translate` creates a translation in connected mode, and
:guilabel:`Copy` creates a copy in free mode. If a record has translations
already, the wizard offers only their mode, so that the modes do not mix.
The Editors Guide describes how to translate in detail, see
`Working with languages <https://docs.typo3.org/permalink/t3editors:languages>`_.


..  _localized-connected-content:

Connected content
=================

In connected mode, the
`site configuration <https://docs.typo3.org/permalink/t3coreapi:sitehandling>`_
decides what a page shows for a content element without a translation. The
fallback type `strict` is the default, so a language without a
`fallbackType` uses it:

..  literalinclude:: /CodeSnippets/config/sites/my_site/config.yaml
    :caption: config/sites/my_site/config.yaml
    :visible-lines: 5, 23-24, 30
    :emphasize-lines: 30

TYPO3 first fetches the records of the default language, and then overlays
them with their translations in the target language. It leaves out a record
that has no translation.

A page in such a language shows only its translated content elements. Here,
the title of the Arabic imprint is translated, but its text is not:

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :card-height: 100
    :class: pb-4

    ..  card:: English

        ..  figure:: /Images/GeneratedScreenshots/LocalizedContent/FrontendEnglish.png
            :alt: The English imprint with its title and its text

            The English imprint

    ..  card:: العربية

        ..  figure:: /Images/GeneratedScreenshots/LocalizedContent/FrontendStrict.png
            :alt: The Arabic imprint with its title, but without its text

            The Arabic imprint shows only its translated title

A fallback chain shows the content of another language instead. Set the
fallback type `fallback`, and list the IDs of the languages to fall back to
in `fallbacks`, separated by commas:

..  literalinclude:: /CodeSnippets/config/sites/my_site/config.yaml
    :caption: config/sites/my_site/config.yaml
    :visible-lines: 5, 13-14, 20-22
    :emphasize-lines: 20-22

In this mode, TYPO3 also fetches the records of the default language first,
and then overlays them with the target language. If a record has no
translation in the target language, TYPO3 goes through the fallback chain
from left to right. A chain such as `1,0` tries the language with the ID 1
first, and then the default language with the ID 0.

Here, Spanish falls back to English. The Spanish imprint shows its translated
title and the English text:

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :card-height: 100
    :class: pb-4

    ..  card:: English

        ..  figure:: /Images/GeneratedScreenshots/LocalizedContent/FrontendEnglish.png
            :alt: The English imprint with its title and its text

            The English imprint

    ..  card:: Español

        ..  figure:: /Images/GeneratedScreenshots/LocalizedContent/FrontendFallback.png
            :alt: The Spanish imprint, with its text in English

            The Spanish imprint falls back to the English text

..  warning::
    TYPO3 renders the content of a page in connected mode starting from the
    default language. If you use connected mode together with the setting
    `Hide default language of page <https://docs.typo3.org/permalink/t3translate:localization-overview-hide-default-language>`_,
    create the content elements in the default language anyway, and
    translate them.

..  _localized-content-free-content:

Free content
============

In free mode, set the fallback type `free` in the
`site configuration <https://docs.typo3.org/permalink/t3coreapi:sitehandling>`_:

..  literalinclude:: /CodeSnippets/config/sites/my_site_free/config.yaml
    :caption: config/sites/my_site/config.yaml
    :visible-lines: 5, 13-14, 20
    :emphasize-lines: 20

TYPO3 then fetches the records of the target language directly, and ignores
the records of the default language. A page shows the translations and the
copies in its language, also a translation whose original is hidden.

..  tip::
    To learn how to add languages and configure them in the site
    configuration, see
    `Adding languages <https://docs.typo3.org/permalink/t3coreapi:sitehandling-addinglanguages>`_.


..  _localized-content-all-language:

The "All" language
==================

A record in the language "All" appears in every language of the site, in
connected mode and in free mode. The ID of this language is -1.

..  figure:: /Images/GeneratedScreenshots/LocalizedContent/AllLanguagesField.png
    :alt: The Language field of a content element, set to All
    :class: with-shadow

    A content element for all languages

The view :guilabel:`Language Comparison` of the :guilabel:`Content > Layout`
module shows the languages of a page side by side. An element for all
languages appears only in the column of the default language. The columns of
the translations stay empty, and the translation wizard does not offer the
element for translation:

..  figure:: /Images/GeneratedScreenshots/LocalizedContent/AllLanguagesLayout.png
    :alt: The Layout module with an element for all languages in one column
    :class: with-shadow

    A content element for all languages in the language comparison


..  _localized-content-inline-elements:

Localizing inline elements (IRRE)
=================================

When you translate a record with
:ref:`inline elements (IRRE) <t3tca:columns-inline-introduction>`, TYPO3
translates its inline elements together with it. An inline element that the
original record gets later has no translation yet. The form of the
translation shows it with a dashed border, and offers two buttons to
translate it:

#.  :guilabel:`Localize all records` translates all inline elements that have
    no translation yet.
#.  The button of an inline element translates this element only.

..  figure:: /Images/GeneratedScreenshots/LocalizedContent/InlineElements.png
    :alt: The list items of an Arabic link list, one of them not translated yet
    :class: with-shadow

    A translated list with an item that has no translation yet

A field can also offer :guilabel:`Synchronize with original language`. It
adds the missing translations, and deletes the translations whose original is
gone. The TCA options
`showAllLocalizationLink <https://docs.typo3.org/permalink/t3tca:confval-inline-appearance-showalllocalizationlink>`_
and
`showSynchronizationLink <https://docs.typo3.org/permalink/t3tca:confval-inline-appearance-showsynchronizationlink>`_
of the field switch these buttons on. The lists of the Camino theme offer
the first one, but not the second.
