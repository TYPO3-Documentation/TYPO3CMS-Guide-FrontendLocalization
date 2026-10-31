..  include:: /Includes.rst.txt

..  _language-menu:

=======================
Language selection menu
=======================

A visitor of a multilingual website switches between the languages in a
language menu. The menu shows an entry for each language of the site. Each
entry can look different, depending on its state:

*   Translation exists
*   Translation exists, currently selected
*   Translation missing
*   Translation missing, currently selected

Create the menu with the
`LanguageMenuProcessor <https://docs.typo3.org/permalink/t3tsref:languagemenuprocessor>`_
of a
`PAGEVIEW <https://docs.typo3.org/permalink/t3tsref:cobj-pageview>`_, or with
the `HMENU <https://docs.typo3.org/permalink/t3tsref:cobj-hmenu>`_ content
object of the
`special type language <https://docs.typo3.org/permalink/t3tsref:hmenu-special-language>`_.

..  _language-menu-tmenu:

LanguageMenuProcessor example
=============================

The Camino theme shows a language menu in the header of the website. It lists
the languages of the site, and grays out the languages that the page has no
translation in:

..  figure:: /Images/GeneratedScreenshots/LanguageMenu/CaminoLanguageMenu.png
    :alt: The open language menu of the website, with Español grayed out
    :class: with-shadow

    The language menu of a page that has no Spanish translation

The theme adds the processor with its identifier `language-menu` to the
`PAGEVIEW` that renders the page. The following TypoScript does the same:

..  literalinclude:: /CodeSnippets/my_sitepackage/Configuration/Sets/Main/setup.typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/Main/setup.typoscript
    :visible-lines: 1-4, 7, 15-22
    :emphasize-lines: 15-19

With `auto`, the menu lists the languages of the
`site configuration <https://docs.typo3.org/permalink/t3coreapi:sitehandling>`_.
The property
`languages <https://docs.typo3.org/permalink/t3tsref:languagemenuprocessor-languages>`_
also takes a comma-separated list of language IDs, such as `0,1,2`.

The processor passes the menu as an array to
`Fluid <https://docs.typo3.org/permalink/t3coreapi:fluid>`_, in the variable
:fluid:`{languagenavigation}`. The template loops over the array and links each
language:

..  literalinclude:: /CodeSnippets/my_sitepackage/Resources/Private/Templates/Pages/Default.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Templates/Pages/Default.fluid.html
    :language: html
