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


TemplaVoilà Page Module
^^^^^^^^^^^^^^^^^^^^^^^

TemplaVoilà's page module has a tab for localization specific options:

|img-75|

- “ **Show page language version”:** This defines the language used to
  select from the FlexForm data structure. Usually the effect will be to
  see Flexible Content Elements show their content preview in that
  language.If you have container elements with localization enabled you
  might see an altogether different composition of that page! (Used
  especially for the “Free” paradigm)

- “ **Edit language header”:** Click a flag to edit the page header /
  Alternative Page Language record. This also shows the languages in
  which the page exists already.

- “ **Create new page translation”:** Select a language which the page
  has not yet been translated to in order to start translation!

For the “Bound” paradigm the “Show page language version” selector may
be further filtered using a control that allows to scale down the
number of languages displayed in the common structure:

|img-76|


Localization modes for a page Data Structure (“Bound” paradigm)
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Almost by definition a Page Data Structure is a “container element”
because without at least one field that can contain content elements
there is not much content management to do.

As for Flexible Content Elements the most simple localization mode is
the “Disabled” mode for a page Data Structure. This means the  *same
structure of content elements is used for all languages.* This is the
“translation” mode where you do a 1-1 translation of the site. In the
discussion for Flexible Content Elements this has been labeled the
“Bound” paradigm. Opposite to this stands the “Free” paradigm which
essentially is based on creating separate structures of content
elements for each language.


Paradigms
~~~~~~~~~

I have chosen the word “paradigm” to describe the difference between
these concepts because they are basically differences in how you think
of localization. The discussion prior to defining these paradigms also
showed that it was quite hard to tune ones brain into understanding
the other paradigm. If you have a hard time to understand how the
“Bound” paradigm could ever work since it builds the pages for all
languages in the “Default language” structure it is simply because you
have missed a feature in TYPO3 called “content overlay”
(“config.sys\_language\_overlay” in TypoScript). This little feature
means that when a page is displayed in Danish the rendering engine
first selects the default language elements of the page but
subsequently looks for a danish translation related to the default
language element. If found, the Danish content is shown instead. If
you are not familiar with that feature, of course the “Bound” paradigm
seems like an illogical solution.

So, in the “Bound” paradigm the “Disabled” mode allows for a single
content structure to be created which serves all languages.

However, you can choose the other modes as well. Lets try the
“Inheritance mode”:

|img-77| This will show a blank ”Main Content Area” inside of which
you can build a completely different page structure for the danish
language. Since the Inheritance principle applies, this structure will
only be used if you put content element references there - otherwise
the default language structure is used.

Using the “Separate” localization mode will do the same except you
will  *have to* put in content in the Danish language version,
otherwise the page is blank.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   a
   
   
   Disabled
         Disabled
   
   Inheritance
         Inheritance
   
   Separate
         Separate


.. container:: table-row

   a
         Usage
   
   Disabled
         All pages must have exact same structure.
   
   Inheritance
         All pages will have same structure by default - but switching to
         another language will allow separate structures to be built for some
         languages
   
   Separate
         All pages must be separately built for each language.


.. container:: table-row

   a
         Rating
   
   Disabled
         Recommended for most projects
   
   Inheritance
         Recommended if more flexibility is needed for localization of certain
         pages, or if the Data Structure with the container fields also needs
         to carry content like a background image or header text.
   
   Separate
         Most like you will not need this mode unless all pages are sure to be
         different in all language. But you will not loose anything by using
         “Inheritance”, rather gain the possibility of fallback to the default
         language. And further, if you carry through that all pages must be
         specially localized it questions if you should have chosen the one-
         tree-fits-all approach in the first place instead of making a separate
         tree.


.. container:: table-row

   a
         Philosophy
   
   Disabled
         Translation 1-1
         
         ***Recommended***
   
   Inheritance
         Translation / Localization (customized)
   
   Separate
         Localization (customized)


.. ###### END~OF~TABLE ######


Element language in “Inheritance” and “Separate” modes.
"""""""""""""""""""""""""""""""""""""""""""""""""""""""

When building a separate structure of content elements using
“Inheritance” or “Separate” modes for a page or FCE container element
you strictly don't need to tag these elements with a language.
However, for two reasons you will have to:

- If you want language access control to be enforced you will have to
  set the language for elements.

- If you have set up your TypoScript template with
  “config.sys\_language\_overlay = hideNonTranslated” (recommended) you
  will not see anything unless you tag elements with the correct
  language!

Here is an example. First the layout of the page/frontend in default
language:

|img-78|

Then, how it looks with Danish language selected and in the frontend:

|img-79|

Notice how the page structures are very different: For the default
language there were two columns, for the Danish “localized” version
there was only a single content element placed directly in the “Main
Content Area”.

Under normal circumstances where the localization mode of the Page
Data Structure is “Disabled” (or “Inheritance” but with no elements
added for the Danish page language version) you should see this view:

The reason why the page will show danish content is that the
individual elements of the page are localized 1-1
(“config.sys\_language\_overlay” is set of course in order to overlay
default records with their localizations):

|img-80|

- **The element “FCE DS: Disabled”:** Container element creating two
  columns. Is set to the universal language “[All]” and will therefore
  be rendered regardless of selected language on the website.

- **The element “Default language here...”:** Normal “Text” content
  element that has a localized version in Danish. When the page is
  rendered, the default version is selected but overlaid with the danish
  localization on the website (because of “config.sys\_language\_overlay
  = 1”)

- **The element “Universal content”:** A Flexible Content Element with a
  FlexForm Data Structure where localization is enabled (either
  “Inheritance” or “Separate”) and therefore the element in itself is
  set to the universal “[All]” language since the localized content is
  embedded in the FlexForm data.

In case the page Data Structure had localization mode set to
“Disabled” you will see no difference of the Page module view when you
switch “Show page language version” to Danish.

In case the page Data Structure had localization mode set to
“Inheritance” you would see an  *empty* structure when changing to
Danish. Since the mode was “Inheritance” and the danish “Main Content
Area” is blank, the danish rendering will be done with the Default
language structure. But as shown above, the empty Danish structure
*could be used* to build completely different structures if needed.
But the recommendation is that you only do this when strictly needed!

|img-81|

What you just saw is a good case of how the “Bound” paradigm works!
Notice how the localized page was build without creating a separate
structure of elements in the Danish “Main Content Area” but rather
achieved through binding of localizations to their default elements.


Adding elements in only one language
""""""""""""""""""""""""""""""""""""

|img-82| Since for TemplaVoilà localized websites using the “Bound”
paradigm you must use the setting “sys\_language\_overlay” (unless
using “Free” paradigm; building separate structures with “Separate”
mode for containers) you will be able to place solo elements on a page
for the translated languages:

This example shows a danish element which is not bound to a default
language elements but appears solo on the page. It will only be shown
when the danish language is selected. So for the default display it
looks like this:

|img-83|

The Danish display looks like this (notice the extra element in the
bottom):

|img-84|


“Disable”, “Inheritance” and “Separate” modes for containers - case study
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

One would think I have wasted enough time already trying to explain
the details of these modes for container elements but I will not spare
you a chance to see a comparison between them in how they solve the
same problem! Maybe this will visualize it a bit more how the “Bound”
paradigm works.

First, take a look at how the website output looks for both default
language and Danish. This view will be reproduced using the three
difference approaches, representing “Bound” and “Free” paradigms.


Normal display (default language):
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Two content elements are positioned side-by-side by a 2-column
container element:

|img-85|


When "Danish" is selected:
~~~~~~~~~~~~~~~~~~~~~~~~~~

In Danish the two content elements are translated but a third element
has been added specifically for Danish:

|img-86|

Let's take a look at how this can be achieved with TemplaVoilà using
either of the localization modes for the 2-column container element:


“ **Disabled” mode / “Bound” paradigm:**
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

When the container has localization mode set to “Disabled” you will
see this view for the above content. The table also explains how
rendering progresses for English and Danish display:


Show page language version: “English” (Default):
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

- Element [1] is rendered because it has the “Default” language set.

- Element [2] is rendered because it has the “[All]” language set, thus
  universal

- Element [3] and [4] are not rendered - they are set to Danish

|img-87|


Show page language version: “Danish”:
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

For Danish, the structure shown in the page module is the same as for
Default because the localization mode is “Disabled” for the container
element - thus all the localization is handled by the elements
themselves:

- Element [1] is selected because it has “Default” language - but TYPO3
  looks for a localized version (because of
  config.sys\_language\_overlay = 1) and finds Element [3] which is
  rendered (possibly with merged fields according to l10n\_mode)

- Element [2] is rendered because it has the “[All]” language set, thus
  universal. The element is a Flexible Content Element and we can see
  that it has localization enabled for its FlexForm so localization is
  handled internally in the element.

- Element [3] is rendered because it has the Danish language set (this
  was not shown in the default display)

|img-87|


“ **Inheritance” mode / Typically “Free” paradigm:**
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If “Inheritance” mode was used for the container element you would
need this structure to create the same result:


Show page language version: “English” (Default):
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

|img-88|

- Element [5] is rendered because it has the “Default” language set.

- Element [6] is rendered because it has the “[All]” language set, thus
  universal


Show page language version: “Danish”:
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

For Danish, the structure shown in the page module is different.

|img-89|

- Left column:
  
  - Element [7] is meant to be a localization of Element[5] from the
    default view (typically created under the “Free” paradigm), but
    essentially it is just an unrelated copy of that element with Danish
    set as language. (It is considered inconsistent if this element was a
    true localized version of the default element pointing back to it with
    its “transOrigPointerField”. However, that is what the “Free” paradigm
    does when the “Localize” link is clicked for a default record.).
  
  - Element [8] is essentially Element [4] which in the “Inheritance” mode
    is moved to the Danish structure.

- Right column [8]
  
  - This is empty - but because of the “Inheritance” mode it will inherit
    the content from default language (=Element [6]). Since Element [6]
    has the [All] language set it will also render for the danish view.

Interestingly, the structure from “Disabled” mode would also work as
well under “Inheritance” mode. This is a great flexibility as I have
mentioned before but might be two confusing and error-prone if the
users doesn't understand it.

“ **Separate” mode / Only “Free” paradigm:**

With “Separate” mode you will have to create these structures:


Show page language version: “English” (Default):
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

For the default language it is exactly the same as for “Inheritance”
mode:

- Element [10] is rendered because it has the “Default” language set.

- Element [11] is rendered because it has the “[All]” language set, thus
  universal

|img-90|


Show page language version: “Danish”:
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

For Danish, the structure is almost similar to that of “Inheritance”
mode above - except that we had to duplicate (or reference) the
element [14] in the right column since no inheritance exists for
“Separate” mode.

Notice: Elements [11] and [14] didn't have to be [All], could have
been Default and Danish respectively.

|img-91|

**Notes:**

For this example I used a Flexible Content Element as container
element but there is no difference if the page Data Structure itself
had two columns (which is probably more typical).

Also, the Page TSconfig was set to disable the warnings/errors display
when container elements has localization mode set to “Inheritance” or
“Separate”:

::

   mod.web_txtemplavoilaM1.disableContainerElementLocalizationWarning = 1

Finally “config.sys\_language\_overlay = 1” was set in the TypoScript
Template record to enable the overlay of localized versions used in
the “Disabled” mode.

