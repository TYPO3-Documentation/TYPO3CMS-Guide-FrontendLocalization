.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


FlexForm - Containter Elements
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

A "Container Element" refers to a Flexible Content Element which has
one or more fields on root level where references to other content
elements can be placed. Typically such elements are used to create
zones in a grid where content can be placed, thus they serve a
structural purpose.

A classic container element could be a 2-column element, here named
"Curabitur venenatis..." having a "Left column" and "Right column":

|img-54|

In each column you see another content element placed.

On the website it looks like this:

|img-55|

Notice that container elements usually must have the "[All]" language
set so they are rendered for all languages:

|img-56|


Two paradigms of using container elements
"""""""""""""""""""""""""""""""""""""""""

Unfortunately, two different approaches to localizing a website with
container elements have developed. Inside TemplaVoilà's Page module we
had to implement support for both.

By default TemplaVoilà follows the "Bound" paradigm which is the
recommended mode taught by this document while the "Free" paradigm
must be configured via Page TSconfig in order to be reflected in
TemplaVoilà's Page module.

This is the difference:

- " **Bound" paradigm (default, recommended):** Promotes that the
  structure (order and nesting) of content elements on a page should be
  the same for all languages. Consequently, all container elements
  should have data structures where localization mode is "Disabled". All
  content carrying elements (such as "Text & Images") is placed as
  default language elements which can have overlaid localizations
  (requiring "config.sys\_language\_overlay" to be set). Elements unique
  to a language can be placed separately if needed and in the rare case
  where a separate page structure is required, "Inheritance" mode could
  be used for the container element DS.

- " **Free" paradigm (alternative, configurable):** Promotes that the
  structure (order and nesting) of content elements is build separately
  for each language, using either "Inheritance" or "Separate" mode in
  the data structure. While this may seem natural it imposes lots of
  problems; the core localization features are used in a less optimal
  way excluding the possibility of content inheritance; elements can be
  ordered differently which would usually be a mistake; content
  structures deeper than a single level is impossible to synchronize
  technically.

The "Free" paradigm is configured by setting this line in Page
TSconfig::

   mod.web_txtemplavoilaM1.translationParadigm = free

The bottom line is that the "Bound" paradigm is the most flexible with
the least complexity. Therefore this document promotes this solution.
In the following I will try to notify where the difference between the
two is necessary to keep in mind.


Localization mode of Container Elements ("Bound" paradigm)
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

When using Container Elements under the "Bound" paradigm (default and
recommended) you should  *never* use "Separate" mode, you should
*avoid* "Inheritance" since it can confuse and  **the preferred mode
is "Disabled"** .

This recommendation is based on the assumption that most multilingual
websites basically want to  *translate* pages to other languages and
therefore want the  *same order and hierarchy* of content elements for
each language. For this purpose "Disabled" mode for container elements
is the way to go since that will ensure that the page structure is
built by the same content elements regardless of language
(localizations of content carrying elements are supplied as overlays).

However, you might like that some pages on your website could look
entirely different in another language. Maybe you want two columns and
five elements in the bottom for some reason. In such cases you have
moved from  *translating* the page to  *localizing* the page. If this
is a need of yours you should select the "Inheritance" mode because it
gives you this flexibility. Basically; by default it will inherit the
default structure for all languages unless you explicitly choose to
implement one or more languages with their independent structure.

If you are really radical and want all pages in alternative languages
to have its own structure built you can use the "Separate" mode, but
my opinion is that you should probably have chosen not to use the
"one-tree-fits-all" paradigm of localization then! If you want so
radically different a website chances are good that you should have
built a completely separate site for that language then! Otherwise you
will find that all these nice localization techniques mostly work
against you and not with you.


Localization mode of Container Elements ("Free" paradigm)
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""

When using Container Elements under the "Free" paradigm it only makes
sense to use "Inheritance" or "Separate" modes.

Each translation of the page is built by placing content elements in
the container for that particular language. Usually you will try to
place localizations of the default language records in the separate
structure. If you configure TemplaVoilà's Page module with
"mod.web\_txtemplavoilaM1.translationParadigm = free" in Page TSconfig
you will obtain support for this since the link to localize a record
will not only create a localization but also place a reference in the
container field.


Localization mode of Container Elements (Advanced details for "Bound" paradigm)
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Here is a more in-depth and technical description:


Separate mode:
~~~~~~~~~~~~~~

In "Separate" localization mode (<langChildren>0</langChildren>) the
fields containing the relations to the localized content elements are
separate from the default language fields:

|img-57|

What it means is that if you want any elements to appear in Danish you
will  *have to* create relations in the two Danish fields.
TemplaVoilà's page module supports this when you switch the "Show page
language version" to the desired language. But experience shows that
users will be puzzled why nothing is shown for Danish! This is only
useful for building separate structures of content elements.

So altogether the "Separate" localization mode for Flexible Content
Elements with container fields is discouraged.

In the Web>TemplaVoilà control center you will see all Data Structures
with this problem marked with a warning (if "Show Details" is
enabled).

|img-58|

In the TemplaVoilà page module you will also see the warning:

|img-59|

*Notice: If "Free" paradigm is enabled with
"mod.web\_txtemplavoilaM1.translationParadigm = free" these warnings
are removed and references to localizations are created automatically
for you, thus making this mode usable, however not exempt from its
theoretical problems.*


Inheritance mode:
~~~~~~~~~~~~~~~~~

In "Inheritance" localization mode (<langChildren>1</langChildren>)
the fields containing the relations to the localized content elements
are bound to the default language fields:

|img-60|

Since inheritance of values is enabled by default (gray arrows) this
will work because values are also used for Danish rendering. But - if
a user adds a relation to any of the Danish fields that relation is
used instead (as expected) but TemplaVoilà will only reflect this in
the Page module if that language is selected (in "Show page language
version"). This could be confusing for users.

Here, you can see how the view for the default language looks:

|img-61|

And here is the view for the Danish language selected:

|img-62|

On the website for the Danish page you will see a funny mix because
the left column will contain the rendering of the element "Fusce
adipiscing..." specifically set for the Danish view while the right
column inherits the reference to the element "Universal content".

|img-63|

In the TemplaVoilà control center a warning is shown for container
elements with "Inheritance" mode:

|img-64| In the TemplaVoilà page module you will also see a warning:

|img-65|

In case you use "Inheritance" on purpose for your container elements
you can disable this warning using Page TSconfig::

   mod.web_txtemplavoilaM1.disableContainerElementLocalizationWarning_warningOnly = 1

Cases where you might use "Inheritance" for container elements is if
such elements also contains regular input fields which needs
localization.

*Notice: If "Free" paradigm is enabled with
"mod.web\_txtemplavoilaM1.translationParadigm = free" these warnings
are removed and references to localizations are created automatically
for you, thus making this mode usable, however not exempt from its
theoretical problems.*


Disabled mode:
~~~~~~~~~~~~~~

In "Disabled" localization mode (<langDisable>1</langDisable>) the
fields containing the relations to the localized content elements are
used regardless of language! This means that it is the same relations
- those of the default language and shown by the TemplaVoilà page
module - which is used for all languages and with no possibilities of
confusion!

It looks like this:

|img-66|

In the TemplaVoilà control center you see no errors or warnings:

|img-67|

*Notice: If "Free" paradigm is enabled with
"mod.web\_txtemplavoilaM1.translationParadigm = free" localization is
not possible since the "Free" paradigm expects to build separate
structures of content elements for each language.*


Working with "Inheritance" and "Separate" modes for container elements
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

If you choose to work with Inheritance and Separate mode for container
elements you will use the "Show page language version" to switch
between the views (goes for both "Bound" and "Free" paradigms):

|img-68|

