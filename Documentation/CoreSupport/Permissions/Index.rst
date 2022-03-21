.. include:: /Includes.rst.txt


.. _core-support-permissions:

Permissions
^^^^^^^^^^^

You can restrict backend users and groups to edit records
only in specific languages. The permissions are enforced
over all tables by checking the language defined in the
:ref:`"languageField" of the table <core-support-tca-languagefield>`.
The "Limit to languages" setting is found in the "Access Lists" tab:

.. figure:: /Images/ManualScreenshots/BackendUsers/CoreSupportLimitToLanguages.png
   :alt: Setting language limitations

   Restricting backend users or groups to one or more languages

Settings from groups and sub-groups are all added together.

If a user has no "Limit to languages" checkboxes set at all he can
edit *all languages* .

Regardless of "Limit to languages" all users can edit records with
"[All]" language.

Setting "Limit to languages" is not only good to protect translators
from editing other languages or default content - it is also helpful
to limit the confusion a user might have when faced with modules
displaying translations for a host of other languages!
