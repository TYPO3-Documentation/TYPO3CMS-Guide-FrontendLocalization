..  include:: /Includes.rst.txt

..  _page-translations:

=================
Translating pages
=================

To translate a page, create a translation of it in the backend:

#.  Open the :guilabel:`Content > Layout` module.
#.  Select the page in the page tree.
#.  Open the language menu in the header of the module. It lists the
    languages of the site configuration.
#.  Choose the language below **Create new translation**. There, the menu
    lists the languages that the page has no translation for yet. The
    translation wizard opens.
#.  Follow the steps of the wizard. You can choose the language to
    translate from, and select content elements of the page, to translate
    them together with the page.

..  figure:: /Images/GeneratedScreenshots/PageTranslations/LanguageMenu.png
    :alt: The language menu offers Español below Create new translation
    :class: with-shadow

    The language menu offers the languages that the page has no translation
    for yet

..  figure:: /Images/GeneratedScreenshots/PageTranslations/TranslationWizard.png
    :alt: The translation wizard asks for the source language
    :class: with-shadow

    The translation wizard asks for the language to translate from

The wizard creates the translation of the page, and the module then shows
the page in the new language.

TYPO3 copies the page properties from the default language. It writes a
prefix such as "[Translate to Español:]" in front of the title, the subtitle,
the keywords, the description, and the abstract. Edit the page properties of
the translation, and replace the copied text and the prefix with the
translation:

..  figure:: /Images/GeneratedScreenshots/PageTranslations/PageProperties.png
    :alt: The title of the Spanish translation with the prefix
    :class: with-shadow

    The title of the translation, with the prefix, and the title of the
    default language below

Most of the fields are the same as for the page in the default language.
Below each field, the form shows the value of the default language.

The page TSconfig option
`translateToMessage <https://docs.typo3.org/permalink/t3tsref:pagetcemain-translatetomessage>`_
sets the text of the prefix. The option
`disablePrependAtCopy <https://docs.typo3.org/permalink/t3tsref:pagetcemaintables-disableprependatcopy>`_
switches the prefix off. The Camino theme sets this option for all tables,
so a site with Camino gets no prefix.
