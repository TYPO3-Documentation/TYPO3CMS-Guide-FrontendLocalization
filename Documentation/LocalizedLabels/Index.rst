..  include:: /Includes.rst.txt

..  _localized-labels:

================
Localized labels
================


..  _localized-labels-typoscript:

Using XLF labels in TypoScript structures
=========================================

:ref:`XLIFF (XLF) <t3coreapi:xliff>` files are XML files containing labels that
the system can retrieve in a localized version if the appropriate translations
are installed. It is possible to retrieve values from XLF files using
TypoScript:

..  code-block:: typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/Main/setup.typoscript

    page.20 = TEXT
    page.20.data = LLL:EXT:theme_camino/Resources/Private/Language/messages.xlf:menu.label

This looks for the label `menu.label` in the file
:file:`Resources/Private/Language/messages.xlf` of the Camino theme,
:composer:`typo3/theme-camino`.

A page in Spanish needs Spanish in the
:ref:`site configuration <languages>`. TYPO3 then looks for the translation
in the :ref:`labels path <t3coreapi:Environment-labels-path>`, in
:file:`es/theme_camino/Resources/Private/Language/es.messages.xlf`. A
language pack installs the file there. If the file translates the label, the
output is "Menú". Otherwise, the output is the English label "Menu".


..  _localized-labels-plugins:

Using XLF labels in frontend plugins
====================================

Making your code ready for internationalization is covered in
:ref:`Localization: translating labels in TYPO3
<t3coreapi:internationalization>`
and the basics about XLIFF files are found in
:ref:`Translation files (XLIFF format) <t3coreapi:xliff>` ("TYPO3 Explained").
Properly made plugins should use XLIFF files for every label that
they used, so that they can be translated and thus generate a proper
output when a specific language is requested.

For instance, the Camino theme labels the button of its menu with an XLIFF
label. With the translations installed, the Spanish and the Arabic pages
show the label in their language:

..  card-grid::
    :columns: 1
    :columns-md: 3
    :gap: 4
    :card-height: 100
    :class: pb-4

    ..  card:: English

        ..  figure:: /Images/GeneratedScreenshots/LocalizedLabels/MenuEnglish.png
            :alt: The header of the website with the button Menu

            The English label

    ..  card:: Español

        ..  figure:: /Images/GeneratedScreenshots/LocalizedLabels/MenuSpanish.png
            :alt: The header of the website with the button Menú

            The Spanish label

    ..  card:: العربية

        ..  figure:: /Images/GeneratedScreenshots/LocalizedLabels/MenuArabic.png
            :alt: The header of the website with the button in Arabic

            The Arabic label

Overriding an existing translation is possible using custom XLIFF files.
This process is described in
:ref:`Overriding or extending translations
<t3coreapi:xliff-translating-custom>`.

It is also possible to override a label using TypoScript. See the
:ref:`TypoScript Reference for more information
<t3tsref:setup-plugin-local-lang-lang-key-label-key>`.

You can also create XLIFF files for a language into which
TYPO3 is not translated yet. This process is described in
:ref:`Adding custom languages <t3coreapi:xliff-translating-languages>`.
