.. include:: ../Includes.txt


.. _localized-labels:

Localized labels
^^^^^^^^^^^^^^^^


.. _localized-labels-typoscript:

Using XLF labels in TypoScript structures
"""""""""""""""""""""""""""""""""""""""""

XLIFF (XLF) files are XML files containing labels that the system can fetch
in a localized version if the relevant translations are installed.
It is possible to retrieve values from XLF files using TypoScript:

.. code-block:: typoscript

   page.20 = TEXT
   page.20.data = LLL:EXT:indexed_search/Resources/Private/Language/locallang.xlf:form.submit

This looks for the label :code:`form.submit` in the file
:file:`Resources/Private/Language/locallang.xlf` from extension
"indexed\_search".

If the :code:`config.language` value is set to "de" and the German translations
are installed in :ref:`t3coreapi:Environment-labels-path`/:file:`de/`, the output should be "Suche"
(instead "Search" which is what you will get if the label is retrieved
for the default language).


.. _localized-labels-plugins:

Using XLF labels in frontend plugins
""""""""""""""""""""""""""""""""""""

Making your code ready for internationalization is covered in
:ref:`Inside TYPO3 <t3inside:internationalization-localization>` and
basics about XLIFF files are found in :ref:`Core APIs <t3coreapi:xliff>`.
Properly made plugins should use XLIFF files for every label that
they used, so that they can be translated and thus generate a proper
output when a specific language is requested.

For instance, if :code:`config.language = de` and the German translations
are installed, you will see this page for "indexed search":

.. figure:: ../Images/IndexedSearchGerman.png
   :alt: Indexed search in German

   Output from the indexed search plugin in German

Overriding an existing translation is possible using custom XLIFF files.
This process is described in :ref:`Core APIs <t3coreapi:xliff-translating-custom>`.

It is also possible to override a label using TypoScript, but this
works only for plugins based on the :code:`\TYPO3\CMS\Frontend\Plugin\AbstractPlugin`
class and not for those based on Extbase. See the
:ref:`TypoScript Reference for more information <t3tsref:setup-plugin-local-lang-lang-key-label-key>`.

It is also possible to create XLIFF files for a language into which
TYPO3 CMS is not translated yet. This process is also described in
:ref:`Core APIs <t3coreapi:xliff-translating-languages>`.
