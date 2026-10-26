..  include:: /Includes.rst.txt

..  _languages:

====================
Setting up languages
====================

Languages are defined in the :ref:`site configuration <t3coreapi:sitehandling>`
for each root page. When creating a new page on root level via TYPO3 backend,
a very basic site configuration is generated on the fly. It prevents immediate
errors due to missing configuration and can also serve as a starting point for
all further actions.

..  _languages-site-management:

Sites module
============

Add the languages of a site in the :guilabel:`Sites > Setup` module, on the
:guilabel:`Languages` tab of the site configuration.

..  figure:: /Images/GeneratedScreenshots/SettingUpLanguages/SiteLanguages.png
    :alt: The Languages tab of a site configuration with three languages
    :class: with-shadow

    A site with English as the default language, Español, and Arabic

..  tip::
    Detailed information on how to extend the site configuration
    with additional languages can be found in the
    :ref:`site handling documentation
    <t3coreapi:sitehandling-addingLanguages>`.

Once you have defined at least one additional language, you can translate
pages and content. The :guilabel:`Content > Records` module shows the
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
