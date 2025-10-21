.. include:: /Includes.rst.txt

.. _languages:

====================
Setting up languages
====================

Languages are defined in the :ref:`site configuration <t3coreapi:sitehandling>`
for each root page. When creating a new page on root level via TYPO3 backend,
a very basic site configuration is generated on the fly. It prevents immediate
errors due to missing configuration and can also serve as a starting point for
all further actions.

Site Management
===============

The `Introduction Package`_'s default languages are English, Danish
and German languages. Adding a new language is done in the
:guilabel:`Site Management > Sites` module of the backend.

..  _Introduction Package: https://extensions.typo3.org/extension/introduction

..  figure:: /Images/ManualScreenshots/SiteConfiguration/SiteConfiguration.png
    :alt: Editing a site configuration
    :class: with-shadow

    Editing form for a site configuration

..  tip::
    Detailed information on how to extend the site configuration
    with additional languages can be found in the
    :ref:`site handling documentation <t3coreapi:sitehandling-addingLanguages>`.

Once you have defined at least one additional language, you will be able to
translate pages and content. For example, the :guilabel:`Content > List` module will
show links for translation if you have translated the page.

..  figure:: /Images/ManualScreenshots/ListModule/LocalizeLinks.png
    :alt: Content elements with localize links
    :class: with-shadow

    The :guilabel:`Content > List` view, with page translations and localize links for content elements

Translated elements appears nested "under" their default language
parent element in the :guilabel:`Content > List` view.

..  figure:: /Images/ManualScreenshots/ListModule/NestedTranslations.png
    :alt: Nested translations
    :class: with-shadow

    The :guilabel:`Content > List` view shows translations nested under their parent
