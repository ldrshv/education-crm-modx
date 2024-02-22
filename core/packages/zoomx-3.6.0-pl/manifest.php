<?php return array (
  'manifest-version' => '1.1',
  'manifest-attributes' => 
  array (
    'changelog' => 'Changelog for ZoomX.

3.6.0-pl
==============
- Added creation of the $_POST array from json data.
- Fixed route parsing for JSON requests again.

3.5.1-pl
==============
- Fixed route parsing for JSON requests.

3.5.0-pl
==============
- Added file plugins for mgr context.
- Added support for contexts.
- Improved the "resource" modifier.
- Fixed plugin error during testing.
- Fixed a bug with the route file (#18).

3.4.2-pl
==============
- Fixed a bug with multiple calls of the same snippet with a set of parameters.
- Fixed a bug with empty plugin list (#6).
- The $events property of a file plugin can be an empty array (#7).
- Added system setting "zoomx_config_path" for ZoomX configs (#8).
- Smarty caching is now available for resources with DB Smarty template (#12).
- Removed private magic methods of the Service class for PHP8 compatibility (#13).

3.4.1-pl
==============
- Fixed the "runSnippet" and the "runFileSnippet" methods of the main service class.
- Fixed creation of Smarty directories.
- Fixed a bug with the controller method disappearing.
- Fixed a bug with controller\'s namespace.

3.4.0-pl
==============
- Added support for file plugins.
- Added modifier "markdown".
- Added the ability to specify the caching time for snippets.
- Added the ability to use short controller names.
- Added short redirect format in routes.
- Added the "OnBeforeRouteProcess" event.
- Added the "zoomx_cache_event_map" system setting.
- Added the "zoomx_controller_namespace" system setting.
- Improved the function jsonx.
- Fixed a bug in the header name Content-Type for JSON requests.
- Refactored security functionality.

3.3.0-pl
==============
- Added route caching.
- Added multiple paths for snippets.
- Fixed a bug with unpublished resources (#3).

3.2.0-pl
==============
- Added modifier "fuzzyDate".
- Added modifier "dateAgo".
- Fixed a bug with the availability of the $zoomx object in templates (#1).
- Refactored the mechanism of virtual pages (#2).

3.1.0-beta
==============
- Added modifier "declension".
- Added the ability to use snippets as modifiers.
- Added the "source" parameter to the request info.

3.0.2-beta
==============
- Refactored the automatic content type detection.
- Fixed the parse block for Smarty.

3.0.1-beta
==============
- Added missing pdoTools adapter files.

3.0.0-beta
==============
*******************************************************************************************
*  WARNING! Only for a new installation. Do not update the previously installed version.  *
*******************************************************************************************
- Required PHP Version 7.1+.
- Added Smarty as a default parser.
- Added pdoTools adapter that replaces Fenom template engine with Smarty in pdoTools snippets.
- Added support for file elements (snippets and chunks).
- Added exception handler with trace details.
- Added the helper function "filex" for downloading files.
- Added the helper function "redirectx" for managing redirects.
- Added onZoomxInit event.
- Added the ability to extend the Service class using macros.
- Added Smarty security support.
- Particular virtual pages.

2.1.1-beta
==============
- Some bugfixes.

2.1.0-beta
==============
- Added "zoomx_autoload_resource" system setting which allows to disable the search and auto-loading the resource for the corresponding URI.
- Fixed a bug when working in CLI mode.
- Returned support of the GET parameter "q".

2.0.0-beta
==============
- Added API mode that supports REST architecture.
- Added support for controllers in routes.
- Added OnRequestError event for error codes 400, 406, 415, 503 and any custom codes.
- Added shorthand modifiers "js", "css" and "html".
- Added MODX like tag syntax ({\'*pagetitle\'}, {\'%lexicon\'}, {\'++setting\'}, {\'~5\'}).
- Refactored modifiers "url" and "lexicon".
- Renamed the system setting "zoomx_routs_mode" on "zoomx_routing_mode".

1.0.2-beta
==============
- Fixed bug with the path for compiled templates.
- Added block "modx".

1.0.1-beta
==============
- Allow the $modx object in templates.
- Fixed bug with uninstalling.
- Added modifier "modx".
- Some code refactoring.

1.0.0-beta
==============
- Initial release.
',
    'license' => 'GNU GENERAL PUBLIC LICENSE
   Version 2, June 1991
--------------------------

Copyright (C) 1989, 1991 Free Software Foundation, Inc.
59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

Everyone is permitted to copy and distribute verbatim copies
of this license document, but changing it is not allowed.

Preamble
--------

  The licenses for most software are designed to take away your
freedom to share and change it.  By contrast, the GNU General Public
License is intended to guarantee your freedom to share and change free
software--to make sure the software is free for all its users.  This
General Public License applies to most of the Free Software
Foundation\'s software and to any other program whose authors commit to
using it.  (Some other Free Software Foundation software is covered by
the GNU Library General Public License instead.)  You can apply it to
your programs, too.

  When we speak of free software, we are referring to freedom, not
price.  Our General Public Licenses are designed to make sure that you
have the freedom to distribute copies of free software (and charge for
this service if you wish), that you receive source code or can get it
if you want it, that you can change the software or use pieces of it
in new free programs; and that you know you can do these things.

  To protect your rights, we need to make restrictions that forbid
anyone to deny you these rights or to ask you to surrender the rights.
These restrictions translate to certain responsibilities for you if you
distribute copies of the software, or if you modify it.

  For example, if you distribute copies of such a program, whether
gratis or for a fee, you must give the recipients all the rights that
you have.  You must make sure that they, too, receive or can get the
source code.  And you must show them these terms so they know their
rights.

  We protect your rights with two steps: (1) copyright the software, and
(2) offer you this license which gives you legal permission to copy,
distribute and/or modify the software.

  Also, for each author\'s protection and ours, we want to make certain
that everyone understands that there is no warranty for this free
software.  If the software is modified by someone else and passed on, we
want its recipients to know that what they have is not the original, so
that any problems introduced by others will not reflect on the original
authors\' reputations.

  Finally, any free program is threatened constantly by software
patents.  We wish to avoid the danger that redistributors of a free
program will individually obtain patent licenses, in effect making the
program proprietary.  To prevent this, we have made it clear that any
patent must be licensed for everyone\'s free use or not licensed at all.

  The precise terms and conditions for copying, distribution and
modification follow.


GNU GENERAL PUBLIC LICENSE
TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
---------------------------------------------------------------

  0. This License applies to any program or other work which contains
a notice placed by the copyright holder saying it may be distributed
under the terms of this General Public License.  The "Program", below,
refers to any such program or work, and a "work based on the Program"
means either the Program or any derivative work under copyright law:
that is to say, a work containing the Program or a portion of it,
either verbatim or with modifications and/or translated into another
language.  (Hereinafter, translation is included without limitation in
the term "modification".)  Each licensee is addressed as "you".

Activities other than copying, distribution and modification are not
covered by this License; they are outside its scope.  The act of
running the Program is not restricted, and the output from the Program
is covered only if its contents constitute a work based on the
Program (independent of having been made by running the Program).
Whether that is true depends on what the Program does.

  1. You may copy and distribute verbatim copies of the Program\'s
source code as you receive it, in any medium, provided that you
conspicuously and appropriately publish on each copy an appropriate
copyright notice and disclaimer of warranty; keep intact all the
notices that refer to this License and to the absence of any warranty;
and give any other recipients of the Program a copy of this License
along with the Program.

You may charge a fee for the physical act of transferring a copy, and
you may at your option offer warranty protection in exchange for a fee.

  2. You may modify your copy or copies of the Program or any portion
of it, thus forming a work based on the Program, and copy and
distribute such modifications or work under the terms of Section 1
above, provided that you also meet all of these conditions:

    a) You must cause the modified files to carry prominent notices
    stating that you changed the files and the date of any change.

    b) You must cause any work that you distribute or publish, that in
    whole or in part contains or is derived from the Program or any
    part thereof, to be licensed as a whole at no charge to all third
    parties under the terms of this License.

    c) If the modified program normally reads commands interactively
    when run, you must cause it, when started running for such
    interactive use in the most ordinary way, to print or display an
    announcement including an appropriate copyright notice and a
    notice that there is no warranty (or else, saying that you provide
    a warranty) and that users may redistribute the program under
    these conditions, and telling the user how to view a copy of this
    License.  (Exception: if the Program itself is interactive but
    does not normally print such an announcement, your work based on
    the Program is not required to print an announcement.)

These requirements apply to the modified work as a whole.  If
identifiable sections of that work are not derived from the Program,
and can be reasonably considered independent and separate works in
themselves, then this License, and its terms, do not apply to those
sections when you distribute them as separate works.  But when you
distribute the same sections as part of a whole which is a work based
on the Program, the distribution of the whole must be on the terms of
this License, whose permissions for other licensees extend to the
entire whole, and thus to each and every part regardless of who wrote it.

Thus, it is not the intent of this section to claim rights or contest
your rights to work written entirely by you; rather, the intent is to
exercise the right to control the distribution of derivative or
collective works based on the Program.

In addition, mere aggregation of another work not based on the Program
with the Program (or with a work based on the Program) on a volume of
a storage or distribution medium does not bring the other work under
the scope of this License.

  3. You may copy and distribute the Program (or a work based on it,
under Section 2) in object code or executable form under the terms of
Sections 1 and 2 above provided that you also do one of the following:

    a) Accompany it with the complete corresponding machine-readable
    source code, which must be distributed under the terms of Sections
    1 and 2 above on a medium customarily used for software interchange; or,

    b) Accompany it with a written offer, valid for at least three
    years, to give any third party, for a charge no more than your
    cost of physically performing source distribution, a complete
    machine-readable copy of the corresponding source code, to be
    distributed under the terms of Sections 1 and 2 above on a medium
    customarily used for software interchange; or,

    c) Accompany it with the information you received as to the offer
    to distribute corresponding source code.  (This alternative is
    allowed only for noncommercial distribution and only if you
    received the program in object code or executable form with such
    an offer, in accord with Subsection b above.)

The source code for a work means the preferred form of the work for
making modifications to it.  For an executable work, complete source
code means all the source code for all modules it contains, plus any
associated interface definition files, plus the scripts used to
control compilation and installation of the executable.  However, as a
special exception, the source code distributed need not include
anything that is normally distributed (in either source or binary
form) with the major components (compiler, kernel, and so on) of the
operating system on which the executable runs, unless that component
itself accompanies the executable.

If distribution of executable or object code is made by offering
access to copy from a designated place, then offering equivalent
access to copy the source code from the same place counts as
distribution of the source code, even though third parties are not
compelled to copy the source along with the object code.

  4. You may not copy, modify, sublicense, or distribute the Program
except as expressly provided under this License.  Any attempt
otherwise to copy, modify, sublicense or distribute the Program is
void, and will automatically terminate your rights under this License.
However, parties who have received copies, or rights, from you under
this License will not have their licenses terminated so long as such
parties remain in full compliance.

  5. You are not required to accept this License, since you have not
signed it.  However, nothing else grants you permission to modify or
distribute the Program or its derivative works.  These actions are
prohibited by law if you do not accept this License.  Therefore, by
modifying or distributing the Program (or any work based on the
Program), you indicate your acceptance of this License to do so, and
all its terms and conditions for copying, distributing or modifying
the Program or works based on it.

  6. Each time you redistribute the Program (or any work based on the
Program), the recipient automatically receives a license from the
original licensor to copy, distribute or modify the Program subject to
these terms and conditions.  You may not impose any further
restrictions on the recipients\' exercise of the rights granted herein.
You are not responsible for enforcing compliance by third parties to
this License.

  7. If, as a consequence of a court judgment or allegation of patent
infringement or for any other reason (not limited to patent issues),
conditions are imposed on you (whether by court order, agreement or
otherwise) that contradict the conditions of this License, they do not
excuse you from the conditions of this License.  If you cannot
distribute so as to satisfy simultaneously your obligations under this
License and any other pertinent obligations, then as a consequence you
may not distribute the Program at all.  For example, if a patent
license would not permit royalty-free redistribution of the Program by
all those who receive copies directly or indirectly through you, then
the only way you could satisfy both it and this License would be to
refrain entirely from distribution of the Program.

If any portion of this section is held invalid or unenforceable under
any particular circumstance, the balance of the section is intended to
apply and the section as a whole is intended to apply in other
circumstances.

It is not the purpose of this section to induce you to infringe any
patents or other property right claims or to contest validity of any
such claims; this section has the sole purpose of protecting the
integrity of the free software distribution system, which is
implemented by public license practices.  Many people have made
generous contributions to the wide range of software distributed
through that system in reliance on consistent application of that
system; it is up to the author/donor to decide if he or she is willing
to distribute software through any other system and a licensee cannot
impose that choice.

This section is intended to make thoroughly clear what is believed to
be a consequence of the rest of this License.

  8. If the distribution and/or use of the Program is restricted in
certain countries either by patents or by copyrighted interfaces, the
original copyright holder who places the Program under this License
may add an explicit geographical distribution limitation excluding
those countries, so that distribution is permitted only in or among
countries not thus excluded.  In such case, this License incorporates
the limitation as if written in the body of this License.

  9. The Free Software Foundation may publish revised and/or new versions
of the General Public License from time to time.  Such new versions will
be similar in spirit to the present version, but may differ in detail to
address new problems or concerns.

Each version is given a distinguishing version number.  If the Program
specifies a version number of this License which applies to it and "any
later version", you have the option of following the terms and conditions
either of that version or of any later version published by the Free
Software Foundation.  If the Program does not specify a version number of
this License, you may choose any version ever published by the Free Software
Foundation.

  10. If you wish to incorporate parts of the Program into other free
programs whose distribution conditions are different, write to the author
to ask for permission.  For software which is copyrighted by the Free
Software Foundation, write to the Free Software Foundation; we sometimes
make exceptions for this.  Our decision will be guided by the two goals
of preserving the free status of all derivatives of our free software and
of promoting the sharing and reuse of software generally.

NO WARRANTY
-----------

  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
REPAIR OR CORRECTION.

  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
POSSIBILITY OF SUCH DAMAGES.

---------------------------
END OF TERMS AND CONDITIONS',
    'readme' => '--------------------
ZoomX
--------------------
Author: sergant210
--------------------

An Extra for MODx Revolution that implements the logic of PHP template engines.',
  ),
  'manifest-vehicles' => 
  array (
    0 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modNamespace',
      'guid' => '4db46603594f8942a360d346edab58a3',
      'native_key' => 'zoomx',
      'filename' => 'modNamespace/2efbd2b0048cfc15c64d8d3b32a4441e.vehicle',
      'namespace' => 'zoomx',
    ),
    1 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '06b8eb7d29fbe27173e1b3d9e087cefa',
      'native_key' => 'zoomx_caching',
      'filename' => 'modSystemSetting/2fa14a6662d8fe0dc5d0fc622db016e1.vehicle',
      'namespace' => 'zoomx',
    ),
    2 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '9ef9f75ce39983fc08133ae27b10ceb6',
      'native_key' => 'zoomx_theme',
      'filename' => 'modSystemSetting/5882407359abe7cc352fc81e33abd120.vehicle',
      'namespace' => 'zoomx',
    ),
    3 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '288a3d649491d3c59b6fbc2cb2a94ca2',
      'native_key' => 'zoomx_template_dir',
      'filename' => 'modSystemSetting/0c086ff06399fac593151714ca93393a.vehicle',
      'namespace' => 'zoomx',
    ),
    4 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'bd1850427f7c54f119bc35e0d44ae813',
      'native_key' => 'zoomx_parser_class',
      'filename' => 'modSystemSetting/81a6480af335a44732fd940106e6e4bc.vehicle',
      'namespace' => 'zoomx',
    ),
    5 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '4376c0066556063d20b9ccf73cabfdd7',
      'native_key' => 'zoomx_include_modx',
      'filename' => 'modSystemSetting/1b662c182f31443fdfe06e6adcf1c964.vehicle',
      'namespace' => 'zoomx',
    ),
    6 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd8ed1a1f0a54e0557df667944176edb5',
      'native_key' => 'zoomx_http_method_override',
      'filename' => 'modSystemSetting/835ffc532980dd4d4ab95711231e717a.vehicle',
      'namespace' => 'zoomx',
    ),
    7 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '75688d05aea52da184b275d731115856',
      'native_key' => 'zoomx_autoload_resource',
      'filename' => 'modSystemSetting/97b2dc531a263ab586f7959d5cc9255b.vehicle',
      'namespace' => 'zoomx',
    ),
    8 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '2d8973f02b799e2a7056f2813ebc7853',
      'native_key' => 'zoomx_include_request_info',
      'filename' => 'modSystemSetting/8b377b2d3a10e9108cd1b96a7c27c955.vehicle',
      'namespace' => 'zoomx',
    ),
    9 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '984fdeaa6fe83e1bb160862f180c7b2c',
      'native_key' => 'zoomx_file_snippets_path',
      'filename' => 'modSystemSetting/199fec928a0e0477b6437c4c50db8c39.vehicle',
      'namespace' => 'zoomx',
    ),
    10 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '7659408b338b9fcc4b383113fea481d4',
      'native_key' => 'zoomx_autodetect_content_type',
      'filename' => 'modSystemSetting/72272dbbed3bbfa80428c1ba49634d1c.vehicle',
      'namespace' => 'zoomx',
    ),
    11 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'a95f414fbe54ea49daacef2cf315905e',
      'native_key' => 'zoomx_show_error_details',
      'filename' => 'modSystemSetting/cf04f7f0f878a5a57d9ae205dae2319c.vehicle',
      'namespace' => 'zoomx',
    ),
    12 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '182d1d7643b9fc9cb220f05e42f0aeae',
      'native_key' => 'zoomx_enable_pdotools_adapter',
      'filename' => 'modSystemSetting/7e1594341755e7b53ddfc8ec34852f67.vehicle',
      'namespace' => 'zoomx',
    ),
    13 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '0353ec46af0f63603787e588277a49c4',
      'native_key' => 'zoomx_use_zoomx_parser_as_default',
      'filename' => 'modSystemSetting/13a8e3229ffc91b50315590b75f2366e.vehicle',
      'namespace' => 'zoomx',
    ),
    14 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'f176fc01c58d85002488ea08cc34684c',
      'native_key' => 'zoomx_enable_exception_handler',
      'filename' => 'modSystemSetting/60c7884191d82b2ecaeeadead64cdfa3.vehicle',
      'namespace' => 'zoomx',
    ),
    15 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '67067d8a902233609b0fb6e4ffe102a1',
      'native_key' => 'zoomx_cache_event_map',
      'filename' => 'modSystemSetting/bb2d2f2285a913d6ad160c180c73f2d8.vehicle',
      'namespace' => 'zoomx',
    ),
    16 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'e57f0338af9bc4186a845d44fbf5da73',
      'native_key' => 'zoomx_config_path',
      'filename' => 'modSystemSetting/7806f6c2929e4f6e38bd7dadf859bf09.vehicle',
      'namespace' => 'zoomx',
    ),
    17 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b3001dcd40e9515a831e20a8ec59ba52',
      'native_key' => 'zoomx_parse_json_to_post',
      'filename' => 'modSystemSetting/d25a14752977de82df45a2a77af0fc1e.vehicle',
      'namespace' => 'zoomx',
    ),
    18 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'bbc7979003bfbcfcfc263cf688b935b4',
      'native_key' => 'zoomx_routing_mode',
      'filename' => 'modSystemSetting/701aa11969ece2b76220f9df7ff00e70.vehicle',
      'namespace' => 'zoomx',
    ),
    19 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'ece9b8e61bfcca2c9be15c6038b3bcaa',
      'native_key' => 'zoomx_cache_routes',
      'filename' => 'modSystemSetting/de096ade44840d69841375614440be76.vehicle',
      'namespace' => 'zoomx',
    ),
    20 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '9845cad94150c98d267ff44c16dfde1a',
      'native_key' => 'zoomx_controller_namespace',
      'filename' => 'modSystemSetting/b39e83bff224ececa574f104770e0682.vehicle',
      'namespace' => 'zoomx',
    ),
    21 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '506aa6d5a487c33737f4412e0bd255c6',
      'native_key' => 'zoomx_smarty_cache_dir',
      'filename' => 'modSystemSetting/e2eb487681a649bb0733a4e23244f566.vehicle',
      'namespace' => 'zoomx',
    ),
    22 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '4bf0f8776fab535db4c79f4fa17b97f8',
      'native_key' => 'zoomx_smarty_compile_dir',
      'filename' => 'modSystemSetting/4d3e4efce1706a8d7007c493719aae99.vehicle',
      'namespace' => 'zoomx',
    ),
    23 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd3cbf011a15d19bd6836f211530467ab',
      'native_key' => 'zoomx_smarty_config_dir',
      'filename' => 'modSystemSetting/b11fe228090c4008ece2fe354afecf94.vehicle',
      'namespace' => 'zoomx',
    ),
    24 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '153f60f8885eea4301cdd3529faab258',
      'native_key' => 'zoomx_smarty_custom_plugin_dir',
      'filename' => 'modSystemSetting/d83bfceda51b0d1544f920c14bb6229a.vehicle',
      'namespace' => 'zoomx',
    ),
    25 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '0f139155c7fbc7d82629f158b34b5076',
      'native_key' => 'zoomx_modx_tag_syntax',
      'filename' => 'modSystemSetting/83eb8585a48c928631627770c7359e6e.vehicle',
      'namespace' => 'zoomx',
    ),
    26 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '99909040ef7656e9ffb35402692fb38e',
      'native_key' => 'zoomx_default_tpl',
      'filename' => 'modSystemSetting/4a6aa4abfc2dd4136c9452f65228eba9.vehicle',
      'namespace' => 'zoomx',
    ),
    27 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '9c20625ae42d0ba65a37d4461e26d33b',
      'native_key' => 'zoomx_template_extension',
      'filename' => 'modSystemSetting/458fc64a8c8f5c01cf099070bb57b837.vehicle',
      'namespace' => 'zoomx',
    ),
    28 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '9e31400aba5aa532f585f255057eec11',
      'native_key' => 'zoomx_smarty_security_class',
      'filename' => 'modSystemSetting/f8e44a42b3d5953b73aeaf31141959fe.vehicle',
      'namespace' => 'zoomx',
    ),
    29 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd0aa14fe9ee495ef02d723efe19c3033',
      'native_key' => 'zoomx_smarty_security_enable',
      'filename' => 'modSystemSetting/66193ea438b0fe9408a2f6e33648928d.vehicle',
      'namespace' => 'zoomx',
    ),
    30 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modCategory',
      'guid' => '36aff302ce70daefe0ce65c004ba18e2',
      'native_key' => NULL,
      'filename' => 'modCategory/0b06ce67489a3534e965478c3dc5327a.vehicle',
      'namespace' => 'zoomx',
    ),
  ),
);