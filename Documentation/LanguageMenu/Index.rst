.. include:: /Includes.rst.txt

.. _language-menu:

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

The `Introduction Package`_ comes with a text-based rendering of the
language menu, located in the footer:

..  figure:: /Images/ManualScreenshots/Frontend/LanguageMenuText.png
    :alt: Text-based language menu
    :class: with-shadow

    A text-based language menu, with active and disabled states

This is the corresponding TypoScript code, that sets up a
`LanguageMenuProcessor` on the page level:

..  code-block:: typoscript
    :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

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

The value for :typoscript:`languages` is a list of comma-separated language
IDs (for example: :typoscript:`0,1,2`) or :typoscript:`auto` to load from
:ref:`site configuration <t3coreapi:sitehandling>`.

The menu is then passed as a hierarchical array to
:ref:`Fluid <t3coreapi:fluid>` in the variable :html:`{languagenavigation}`.
The Fluid template iterates through the array and creates the language links:

..  code-block:: html
    :caption: EXT:site_package/Resources/Private/Templates/SomeTemplate.html

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


..  _Introduction Package: https://extensions.typo3.org/extension/introduction
