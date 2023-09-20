..  include:: /Includes.rst.txt

..  _introduction:

============
Introduction
============

..  _about:

About this document
===================

Creating a website in multiple languages with TYPO3 can be done in a
variety of ways - as usual. Unfortunately, all the options are hard to
understand unless described in a context where used. In addition, even
if you understand the context you might like to get some suggestions
for what others have found to be best-practices.

This document tries to document everything you need to know about
localizing websites with TYPO3. Ideally, it should mention every
feature and what it is good for. However, be sure to use
reference documents like the :ref:`TypoScript Reference <t3tsref:start>`,
:ref:`TYPO3 Explained <t3coreapi:start>`, etc. to look up the
exact syntax for the features mentioned.

Since the main goal of this document is to include all knowledge areas
of localization, it might suffer from a poor composition where advanced
content is mixed here and there. A later revision could maybe make
up for this by better prioritizing the content. For now that has not been
a priority. On the other hand, you will come out as an expert in the
other end.


..  _about-terms:

Localization and Translation
----------------------------

The two terms are often used to express the same. Also in this
document. But more precisely this is how we understand the difference:

Translation
    means that a specific composition of words are translated to another
    language. In other words: If there is a header and an image in the default
    language, so there will be in the translation. No more, no less.

Localization
    means more broadly that a page is represented in another language. This
    means information in that language ("translation") but could also include
    alternative templates, additional composition of content directed to another
    audience, etc. In other words: There might be another number of headers and
    images than in the default language.

TYPO3 handles both types of approaches, but this flexibility has the
price that you need to read this document to find out which approach
to choose for your project!


..  _credits:

Credits
=======

This document was originally written by Kasper Skårhøj.


..  _credits-dedication:

Dedication
----------

    I want to dedicate this document to every native English speaker who
    has over the years learned to live with my gazillions of documents
    full of weird syntactical compositions and understood that it was a
    privilege that a non-native like me after all chose to communicate in
    a foreign language to the best of my abilities.

    -- Kasper
