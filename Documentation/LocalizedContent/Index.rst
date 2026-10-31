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

There are two strategies for handling the translation of content on pages:

Connected mode
    Translating content will create a direct connection between the original
    language and the language you translate to. This means that moving an
    element or setting meta information like start time or end time will be
    taken from the original content and you will not be able to set these
    values on a translated content element. Translated records will hold the
    connection to their original language record in the `l10n_parent`
    field. This mode is best for a strict translation workflow.

Free mode
    Copying content will take the content elements from the source language
    and create copies in a different language. This means that you will be able
    to move content elements around freely, but you will not have the benefit
    of being able to compare changes made in the source language later on.
    Use this mode, when the translated pages content can largely differ from
    the original language and you want to have that freedom in designing your
    translated website.

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
For more details on how to translate, see the
:ref:`TYPO3 Editors Guide <t3editors:languages>`.


..  _localized-connected-content:

Connected content
=================

If you opted for the connected content strategy, this is the default way
that translated pages will be handled in the frontend and requires
no further configuration in the
:ref:`site configuration <t3coreapi:sitehandling>`. In the site configuration,
the fallbackType "strict" would look like this:

..  literalinclude:: /CodeSnippets/config/sites/my_site/config.yaml
    :caption: config/sites/my_site/config.yaml
    :visible-lines: 5, 23-24, 30
    :emphasize-lines: 30

In this connected mode, TYPO3 will first internally fetch the records of the
default language, then overlay them with the target language. If a record is
not translated into the target language, then it is discarded and not shown at
all.

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

Another way to view connected content in the frontend is by creating a fallback
chain. For this we have to adjust the site configuration and provide a
comma-separated list of fallback languages:

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
    If you want to use the "connected content" paradigm in conjunction with the
    setting
    `Hide default language of page <https://docs.typo3.org/permalink/t3translate:localization-overview-hide-default-language>`_,
    you will need to provide placeholder content elements
    in the default language and translate them, since the whole frontend
    rendering process starts from the default language in such a configuration.

..  _localized-content-free-content:

Free content
============

With the free mode content strategy, the
:ref:`site configuration <t3coreapi:sitehandling>` will have to be
adjusted accordingly:

..  literalinclude:: /CodeSnippets/config/sites/my_site_free/config.yaml
    :caption: config/sites/my_site/config.yaml
    :visible-lines: 5, 13-14, 20
    :emphasize-lines: 20

This means, TYPO3 will directly fetch the translated records and not care
about the records in the default language at all.

..  tip::
    For more information on how to add languages and configure their
    behaviour in the site configuration, see
    :ref:`Adding Languages <t3coreapi:sitehandling-addingLanguages>`.


..  _localized-content-all-language:

The "All" language
==================

When using overlays, it becomes possible to use a particular
language called "All", which will be automatically visible across all
translations. The uid of that particular language is "-1".

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
