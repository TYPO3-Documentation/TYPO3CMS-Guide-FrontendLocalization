..  include:: /Includes.rst.txt

..  _localized-labels:

================
Localized labels
================


..  _localized-labels-typoscript:

Using XLIFF labels in TypoScript
================================

`XLIFF files <https://docs.typo3.org/permalink/t3coreapi:xliff>`_ hold the
labels of an extension. TYPO3 reads XLIFF files of the versions 1.2 and 2.0.
If a translation of the labels is installed, TYPO3 outputs a label in the
language of the page. TypoScript can read a label from an XLIFF file:

..  code-block:: typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/Main/setup.typoscript

    page.20 = TEXT
    page.20.data = LLL:EXT:theme_camino/Resources/Private/Language/messages.xlf:menu.label

This looks for the label `menu.label` in the file
:file:`Resources/Private/Language/messages.xlf` of the Camino theme,
:composer:`typo3/theme-camino`.

A page in Spanish needs Spanish in the
`site configuration <https://docs.typo3.org/permalink/t3translate:languages>`_.
TYPO3 then looks for the translation
in the :ref:`labels path <t3coreapi:Environment-labels-path>`, in
:file:`es/theme_camino/Resources/Private/Language/es.messages.xlf`. A
language pack installs the file there. If the file translates the label, the
output is "Menú". Otherwise, the output is the English label "Menu".


..  _localized-labels-plugins:

Using XLIFF labels in frontend plugins
======================================

A plugin outputs every label from an XLIFF file, so that the label can be
translated. To prepare the labels of an extension for translation, see
`Localization in TYPO3 Explained <https://docs.typo3.org/permalink/t3coreapi:internationalization>`_.

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

To override a translation with an XLIFF file of your own, see
`Overriding or extending translations <https://docs.typo3.org/permalink/t3coreapi:xliff-translating-custom>`_.
TypoScript can override a label as well, see
`_LOCAL_LANG <https://docs.typo3.org/permalink/t3tsref:setup-plugin-local-lang-lang-key-label-key>`_.

For a language that TYPO3 has no translations for yet, create the XLIFF
files yourself, see
`Adding custom languages <https://docs.typo3.org/permalink/t3coreapi:xliff-translating-languages>`_.
