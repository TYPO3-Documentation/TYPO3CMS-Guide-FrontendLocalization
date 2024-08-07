..  include:: /Includes.rst.txt

..  _localized-content:

=================
Localized content
=================

..  contents::
    :local:


Introduction
============

There are two strategies for handling the translation of content on pages:

Connected mode
    Translating content will create a direct connection between the original
    language and the language you translate to. This means that moving an
    element or setting meta information like start time or end time will be
    taken from the original content and you will not be able to set these values
    on a translated content element. Translated records will hold the connection
    to their original language record in the :sql:`l10n_parent` field.
    This mode is best for a strict translation workflow.

Free mode
    Copying content will take the content elements from the source language
    and create copies in a different language. This means that you will be able
    to move content elements around freely, but you will not have the benefit of
    being able to compare changes made in the source language later on.
    Use this mode, when the translated pages content can largely differ from
    the original language and you want to have that freedom in designing your
    translated website.

When you start translating a page, the :guilabel:`Web > Page` module will ask
you about this choice when clicking on the :guilabel:`Translate` button:

..  figure:: /Images/ManualScreenshots/PageModule/LocalizedContentTranslationWizard.png
    :alt: The translation wizard showing localization strategies
    :class: with-shadow

    The translation wizard asks for a choice of localization strategy

The :guilabel:`Translate` button corresponds to the connected mode, the
:guilabel:`Copy` button to the free mode. Furthers details on how to proceed with
translations are found in the :ref:`Editor's Tutorial <t3editors:languages>`.


..  _localized-connected-content:

Connected content
=================

If you opted for the connected content strategy, this is the default way
that translated pages will be handled in the frontend and requires
no further configuration in the :ref:`site configuration <t3coreapi:sitehandling>`.
In the site configuration, the fallbackType "strict" would look like this:

..  code-block:: yaml
    :caption: config/sites/my_site/config.yaml

    languages:
      -
        # ... other language settings ...
        fallbackType: strict

In this connected mode, TYPO3 will first internally fetch the records of the
default language, then overlay them with the target language. If a record is
not translated into the target language, then it is discarded and not shown at
all.

The German version will be reduced to the actually translated elements:

..  figure:: /Images/ManualScreenshots/Frontend/LocalizedContentNoOverlay.png
    :alt: English and German translation without overlays
    :class: with-shadow

    English and German translation without overlays

Another way to view connected content in the frontend is by creating a fallback
chain. For this we have to adjust the site configuration and provide a
comma-separated list of fallback languages:

..  code-block:: yaml
    :caption: config/sites/my_site/config.yaml

    languages:
      -
        # ... other language settings ...
        fallbackType: fallback
        # 1 = Danish, 0 = English
        fallbacks: '1,0'

In this mode, TYPO3 will also first internally fetch the records of the
default language and then overlay them with the target language. If no translation
exists for the target language, it will now go from left to right through the
fallback chain and first try to find a translation for the language ID 1 (Danish)
and, if that is a miss as well, fall back to language ID 0 (English).

..  figure:: /Images/ManualScreenshots/Frontend/LocalizedContentTranslationOverlay.png
    :alt: English and German translation with overlays
    :class: with-shadow

    The English version and its German translation, with overlays

..  warning::
    If you want to use the "connected content" paradigm in conjunction with the
    :ref:`"Hide default translation of the page" <localization-overview-hide-default-language>`
    setting, you will need to provide placeholder content elements
    in the default language and translate them, since the whole frontend
    rendering process starts from the default language in such a configuration.

..  _localized-content-free-content:

Free content
============

With the free mode content strategy, the
:ref:`site configuration <t3coreapi:sitehandling>` will have to be
adjusted accordingly:

..  code-block:: yaml
    :caption: config/sites/my_site/config.yaml

    languages:
      -
        # ... other language settings ...
        fallbackType: free

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

..  figure:: /Images/ManualScreenshots/Record/LocalizedContentAllLanguageDefined.png
    :alt: Content element in "All" language
    :class: with-shadow

    A content element valid for all languages

It is also marked with the special language icon in the :guilabel:`Web > Page`
module:

..  figure:: /Images/ManualScreenshots/PageModule/LocalizedContentAllLanguagePageModule.png
    :alt: "All" language in the Page Module
    :class: with-shadow

    An "All" language content element displayed in the :guilabel:`Web > Page` module

Note that no :guilabel:`Translate` button appears, the new content element
is valid for all languages.


..  _localized-content-inline-elements:

Localizing inline elements (IRRE)
=================================

When localizing a record with :ref:`inline elements (IRRE) <t3tca:columns-inline-introduction>`,
the inline elements will be grayed out and not automatically localized. TYPO3
will display two buttons to help you localize and keep the elements in
sync.

..  figure:: ../Images/LocalizedContentLocalizingIrreElements.png
    :alt: Buttons for localizing and synchronizing inline elements
    :class: with-shadow

    Buttons for localizing and synchronizing inline elements

**Localize all records (1)** creates localized versions of all inline
elements from the default language in your current language so that
you can translate them. Each element that has not yet been localized
will also have a :guilabel:`Localize` button (3) that will allow you to localize
individual elements.

**Synchronize with original language (2)** can be clicked when you have
translated the elements and the content in the default language changed.
