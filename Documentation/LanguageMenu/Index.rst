..  include:: /Includes.rst.txt

..  _language-menu:

=======================
Language selection menu
=======================

A visitor to a multilingual website can switch between the site languages
using a language menu. The menu has an entry for each site language.
Each entry can look different depending on its state:

*   Translation exists
*   Translation exists, currently selected
*   Translation missing
*   Translation missing, currently selected

Create the menu using a
`LanguageMenuProcessor <https://docs.typo3.org/permalink/t3tsref:languagemenuprocessor>`_
in a
`PAGEVIEW <https://docs.typo3.org/permalink/t3tsref:cobj-pageview>`_, or using
the `HMENU <https://docs.typo3.org/permalink/t3tsref:cobj-hmenu>`_ content
object of the
`special type language <https://docs.typo3.org/permalink/t3tsref:hmenu-special-language>`_.

..  _language-menu-tmenu:

LanguageMenuProcessor example
=============================

The Camino theme has a language menu in the header of the website. It lists
the site languages, and grays out languages where the page has no
translation:

..  figure:: /Images/GeneratedScreenshots/LanguageMenu/CaminoLanguageMenu.png
    :alt: The open language menu of the website, with Español grayed out
    :class: with-shadow

    The language menu of a page that has no Spanish translation

The theme adds a processor with identifier `language-menu` to the
`PAGEVIEW` that renders the page, as in the following TypoScript:

..  literalinclude:: /CodeSnippets/my_sitepackage/Configuration/Sets/Main/setup.typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/Main/setup.typoscript
    :visible-lines: 1-4, 7, 10-16, 20
    :emphasize-lines: 10-14

If you set `languages` to `auto`, the menu lists the languages that are in the
`site configuration <https://docs.typo3.org/permalink/t3coreapi:sitehandling>`_.
The
`languages <https://docs.typo3.org/permalink/t3tsref:languagemenuprocessor-languages>`_
property can also be set to a comma-separated list of language IDs, such as `0,1,2`.

The processor passes the menu to
`Fluid <https://docs.typo3.org/permalink/t3coreapi:fluid>`_, as an array in the variable
:fluid:`{languagenavigation}`. This template loops over the array and links each
language:

..  literalinclude:: /CodeSnippets/my_sitepackage/Resources/Private/Templates/Pages/Default.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Templates/Pages/Default.fluid.html
    :language: html
    :visible-lines: 1-23, 30
