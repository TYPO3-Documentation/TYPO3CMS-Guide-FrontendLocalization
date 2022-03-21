.. include:: /Includes.rst.txt


.. _language-menu:

=======================
Language selection menu
=======================

To properly navigate a multilingual web site you probably want
to have a language selection menu somewhere. This menu should
show an entry for each possible, with variation of aspect
depending on translation availability, i.e.:

- Translation exists
- Translation exists - currently selected
- Missing translation
- Missing translation - currently selected

This kind of menu can be made by either using a
:ref:`LanguageMenuProcessor on a FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>`
or using the :ref:`HMENU content object <t3tsref:cobj-hmenu>`
with special type :ref:`language <t3tsref:hmenu-special-language>`.

.. _language-menu-tmenu:

LanguageMenuProcessor example
=============================

The Introduction Package comes with a text-based rendering of the
language menu, located in the footer.

.. figure:: ../Images/LanguageMenuText.png
   :alt: Text-based language menu

   A text-based language menu, with active and disabled states

This is the corresponding typoscript code, that sets up a LanguageMenuProcessor on the page level:

.. code-block:: typoscript

   page = PAGE
   page {
      10.dataProcessing {
         40 = TYPO3\CMS\Frontend\DataProcessing\LanguageMenuProcessor
         40 {
             languages = <insert languagemenu-id>
             as = languagenavigation
         }
      }
   }

The menu is then saved as a hierarchical array and available in fluid in the variable {languagenavigation}.
The fluid template now iterates through the navigation and creates the language links:

.. code-block:: html

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

