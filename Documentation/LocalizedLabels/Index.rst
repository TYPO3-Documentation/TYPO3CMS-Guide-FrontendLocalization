..  include:: /Includes.rst.txt

..  _localized-labels:

================
Localized labels
================


..  _localized-labels-typoscript:

Using XLIFF labels in TypoScript
================================

Extension labels are saved in `XLIFF files <https://docs.typo3.org/permalink/t3coreapi:xliff>`_.
TYPO3 can read XLIFF files version 1.2 and 2.0.
If a translation of a label on a page is available, TYPO3 outputs the label in the
language of the page. TypoScript reads a label from an XLIFF file:

..  code-block:: typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/Main/setup.typoscript

    page.20 = TEXT
    page.20.data = LLL:EXT:theme_camino/Resources/Private/Language/messages.xlf:menu.label

This looks for the label `menu.label` in the file
:file:`Resources/Private/Language/messages.xlf` in the Camino theme,
:composer:`typo3/theme-camino`.

A page in Spanish needs Spanish to be available in the
`site configuration <https://docs.typo3.org/permalink/t3translate:languages>`_.
TYPO3 then looks for the translation
in the :ref:`labels path <t3coreapi:Environment-labels-path>`, in
:file:`es/theme_camino/Resources/Private/Language/es.messages.xlf`. A
language pack installs the file there. If the file has a translation for the label, the
output is "Menú". Otherwise, the output is the default English label "Menu".


..  _localized-labels-plugins:

Using XLIFF labels in frontend plugins
======================================

A plugin outputs every label via an XLIFF file, so that labels can be
translated. To prepare labels in an extension for translation, see
`Localization in TYPO3 Explained <https://docs.typo3.org/permalink/t3coreapi:internationalization>`_.

As an example, the Camino theme uses an XLIFF label to label the
menu button. If translations are available, the menu button labels are in
Spanish and the Arabic on the Spanish and Arabic pages:

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

To override a translation with an XLIFF file of your own, see
`Overriding or extending translations <https://docs.typo3.org/permalink/t3coreapi:xliff-translating-custom>`_.
TypoScript can override a label as well, see
`_LOCAL_LANG <https://docs.typo3.org/permalink/t3tsref:setup-plugin-local-lang-lang-key-label-key>`_.

If a language does not have translations in TYPO3, you can create the XLIFF
files yourself, see
`Adding custom languages <https://docs.typo3.org/permalink/t3coreapi:xliff-translating-languages>`_.
