..  include:: /Includes.rst.txt

..  _language-menu:

=======================
Language selection menu
=======================

To properly navigate a multilingual web site you probably want
to have a language selection menu somewhere. This menu should
show an entry for each possible, with variation of aspect
depending on translation availability:

*   Translation exists
*   Translation exists - currently selected
*   Missing translation
*   Missing translation - currently selected

This kind of menu can be made by either using a
:ref:`LanguageMenuProcessor <t3tsref:LanguageMenuProcessor>` on a
:ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>` or using the
:ref:`HMENU content object <t3tsref:cobj-hmenu>` with special type
:ref:`language <t3tsref:hmenu-special-language>`.

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

The following TypoScript code sets up such a menu with a
:php-short:`\TYPO3\CMS\Frontend\DataProcessing\LanguageMenuProcessor`
on the page level:

..  code-block:: typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/Main/setup.typoscript

    page = PAGE
    page {
      10.dataProcessing {
        40 = TYPO3\CMS\Frontend\DataProcessing\LanguageMenuProcessor
        40 {
          languages = <insert language-id> or "auto"
          as = languagenavigation
        }
      }
    }

The value for :typoscript:`languages <t3tsref:LanguageMenuProcessor-languages>`
is a list of comma-separated language IDs (for example: `0,1,2`) or `auto` to
load from :ref:`site configuration <t3coreapi:sitehandling>`.

The menu is then passed as a hierarchical array to
:ref:`Fluid <t3coreapi:fluid>` in the variable :fluid:`{languagenavigation}`.
The Fluid template iterates through the array and creates the language links:

..  code-block:: html
    :caption: EXT:my_sitepackage/Resources/Private/Templates/SomeTemplate.html

    <f:if condition="{languagenavigation}">
      <ul id="language_menu" class="language-menu">
        <f:for each="{languagenavigation}" as="item">
          <li class="{f:if(condition: item.active, then: 'active')} {f:if(condition: item.available, else: 'text-muted')}">
            <f:if condition="{item.available}">
              <f:then>
                <a href="{item.link}" hreflang="{item.hreflang}" title="{item.title}">
                  <span>{item.navigationTitle}</span>
                </a>
              </f:then>
              <f:else>
                <span>{item.navigationTitle}</span>
              </f:else>
            </f:if>
          </li>
        </f:for>
      </ul>
    </f:if>
