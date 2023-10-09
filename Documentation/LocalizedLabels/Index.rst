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
are installed. It is possible to retrieve values from XLF files using TypoScript:

..  code-block:: typoscript
    :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

    page.20 = TEXT
    page.20.data = LLL:EXT:indexed_search/Resources/Private/Language/locallang.xlf:form.submit

This looks for the label :code:`form.submit` in the file
:file:`Resources/Private/Language/locallang.xlf` from the extension
"indexed\_search".

If the frontend is now accessed in the language "de", the German language
is configured in the :ref:`site configuration <languages>` and the German
translations are installed in :ref:`t3coreapi:Environment-labels-path`/:file:`de/`,
the output should be "Suche" (instead "Search" which is what you will get if the
label is retrieved for the default language).


..  _localized-labels-plugins:

Using XLF labels in frontend plugins
====================================

Making your code ready for internationalization is covered in
:ref:`t3coreapi:internationalization` and
basics about XLIFF files are found in :ref:`t3coreapi:xliff` ("TYPO3 Explained").
Properly made plugins should use XLIFF files for every label that
they used, so that they can be translated and thus generate a proper
output when a specific language is requested.

For instance, if the page is accessed in the language "de" and
the German translations are installed, you will see this page for "indexed search":

..  figure:: /Images/ManualScreenshots/Frontend/IndexedSearchGerman.png
    :alt: Output from the Indexed Search plugin in German
    :class: with-shadow

    Output from the Indexed Search plugin in German

Overriding an existing translation is possible using custom XLIFF files.
This process is described in :ref:`t3coreapi:xliff-translating-custom`.

It is also possible to override a label using TypoScript. See the
:ref:`TypoScript Reference for more information <t3tsref:setup-plugin-local-lang-lang-key-label-key>`.

You can also create XLIFF files for a language into which
TYPO3 is not translated yet. This process is described in
:ref:`t3coreapi:xliff-translating-languages`.
