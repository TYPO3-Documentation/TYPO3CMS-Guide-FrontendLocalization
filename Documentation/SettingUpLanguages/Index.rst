..  include:: /Includes.rst.txt

..  _languages:

====================
Setting up languages
====================

A site defines its languages in its
`site configuration <https://docs.typo3.org/permalink/t3coreapi:sitehandling>`_.
When you create a page on the root level of the page tree, TYPO3 creates a
site configuration for it. This configuration has one language, English, as
the default language. Add the other languages of the website to it.

..  _languages-site-management:

Adding languages in the Sites module
====================================

Add the languages of a site in the :guilabel:`Sites > Setup` module, on the
:guilabel:`Languages` tab of the site configuration.

..  figure:: /Images/GeneratedScreenshots/SettingUpLanguages/SiteLanguages.png
    :alt: The Languages tab of a site configuration with three languages
    :class: with-shadow

    A site with English as the default language, Español, and العربية

..  tip::
    `Adding languages <https://docs.typo3.org/permalink/t3coreapi:sitehandling-addinglanguages>`_
    in TYPO3 Explained describes the properties of a language.

As soon as a site has a second language, you can translate its pages and
content. The :guilabel:`Content > Records` module shows the
translations of a page in the languages that you check in its language menu,
at the top right of the module. For each of these languages, it shows the
following:

#.  The translation of the page, below **Page Translation**.
#.  A button in the column **Localize to**, which translates a content
    element into the language. The column offers the languages that the page
    has a translation in.
#.  The translation of a content element, below the element.

..  figure:: /Images/GeneratedScreenshots/SettingUpLanguages/RecordsTranslations.png
    :alt: The Records module with the Arabic records of a page
    :class: with-shadow

    The :guilabel:`Content > Records` module with the Arabic records of a page
