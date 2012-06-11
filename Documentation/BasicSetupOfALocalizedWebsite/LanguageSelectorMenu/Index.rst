.. include:: Images.txt

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Language Selector Menu
^^^^^^^^^^^^^^^^^^^^^^

You probably want to have a website language selector menu somewhere
on your website. This menu should show an entry for each possible
language and since you might not have a translation for each page you
might like the menu items to appear in 4 variants:

- Translation exists

- Translation exists - currently selected

- Missing translation

- Missing translation - currently selected

The way to make such a menu is to use the HMENU cObject from
TypoScript and use the special type “language”.

Here is example configurations:


GMENU example
"""""""""""""

|img-32|

::

   ## Localization menu:
   lib.langMenu = HMENU
   lib.langMenu {
           special = language
           special.value = 0,1,2
           special.normalWhenNoLanguage = 0
           1 = GMENU
           1.NO {
                   XY = [5.w]+4, [5.h]+4
                   backColor = white
                   5 = IMAGE
                   5.file = EXT:cms/tslib/media/flags/flag_uk.gif  || EXT:cms/tslib/media/flags/flag_dk.gif  || EXT:cms/tslib/media/flags/flag_fr.gif
                   5.offset = 2,2
           }
   
           1.ACT < lib.langMenu.1.NO
           1.ACT=1
           1.ACT.backColor = black
   
           1.USERDEF1 < lib.langMenu.1.NO
           1.USERDEF1=1
           1.USERDEF1.5.file = EXT:cms/tslib/media/flags/flag_uk_d.gif  || EXT:cms/tslib/media/flags/flag_dk_d.gif  || EXT:cms/tslib/media/flags/flag_fr_d.gif
           1.USERDEF1.noLink = 0
   
           1.USERDEF2 < lib.langMenu.1.USERDEF1
           1.USERDEF2.backColor = green
   }  


TMENU example
"""""""""""""

|img-33|

::

   lib.langMenu = HMENU
   lib.langMenu {
           special = language
           special.value = 0,1,2
           special.normalWhenNoLanguage = 0
           1 = TMENU
           1 {
                           # Normal link to language that exists:
                   NO = 1
                   NO.allWrap = |*| | *  |*| |
                   NO.linkWrap = <b style="background-color : grey"> | </b>
                   NO.stdWrap.setCurrent = English || Danish || Russian
                   NO.stdWrap.current = 1
   
                           # Current language selected:
                   ACT < .NO
                   ACT.linkWrap = <b style="background-color : red"> | </b>
   
                           # Language that is NOT available:
                   USERDEF1 < .NO
                   USERDEF1.linkWrap = <span style="background-color : yellow"> | </span>
                   USERDEF1.doNotLinkIt = 1
           }
   }

