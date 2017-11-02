<?php
/**
 * Copyright (c) Xerox Corporation, Codendi Team, 2001-2009. All rights reserved
 * Copyright (c) Enalean, 2012 - 2017. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

// Show/manage ugroup list

require_once('pre.php');
require_once('www/project/admin/permissions.php');

function format_html_row($row, &$row_num) {
    echo "<tr class=\"". util_get_alt_row_color($row_num++) ."\">\n";
    foreach($row as $cell) {
        $htmlattrs = '';
        $value = '';
        if(is_array($cell)) {
            if(isset($cell['value'])) {
                $value = $cell['value'];
            }
            if(isset($cell['html_attrs'])) {
                $htmlattrs = ' '.$cell['html_attrs'];
            }
        } else {
            $value = $cell;
        }

        echo '  <td>'.$value."</td>\n";
    }
    echo "</tr>\n";
}

$em      = EventManager::instance();
$request = HTTPRequest::instance();

$group_id = $request->getValidated('group_id', 'GroupId', 0);

$csrf = new CSRFSynchronizerToken('/project/admin/ugroup.php');

session_require(array('group' => $group_id, 'admin_flags' => 'A'));

if ($request->existAndNonEmpty('func')) {
    $ugroup_id   = $request->getValidated('ugroup_id', 'UInt', 0);

    switch($request->get('func')) {
        case 'delete':
            $csrf->check();
            ugroup_delete($group_id, $ugroup_id);
            break;
        case 'do_update':
            $name = $request->getValidated('ugroup_name', 'String', '');
            $desc = $request->getValidated('ugroup_description', 'String', '');
            ugroup_update($group_id, $ugroup_id, $name, $desc);
            $GLOBALS['Response']->redirect('/project/admin/editugroup.php?group_id='.$group_id.'&ugroup_id='.$ugroup_id.'&func=edit&pane=settings');
            break;
    }
    $GLOBALS['Response']->redirect('/project/admin/ugroup.php?group_id='.$group_id);
}

//
// Now display main page
//


project_admin_header(
    array(
        'title'=>$Language->getText('project_admin_ugroup','manage_ug'),
        'group'=>$group_id,
        'help' => 'project-admin.html#user-groups'
    ),
    'groups'
);

$pm = ProjectManager::instance();
$project=$pm->getProject($group_id);

print '<P><h2>'.$Language->getText('project_admin_ugroup','manage_ug_for',$project->getPublicName()).'</h2>';
print '
<P>
<H3><a href="/project/admin/editugroup.php?func=create&group_id='.$group_id.'">'.$Language->getText('project_admin_ugroup','create_ug').'</a></H3>
'.$Language->getText('project_admin_ugroup','create_ug_for_p').'
<p>


<H3>'.$Language->getText('project_admin_ugroup','edit_ug').'</H3>
<P>
<HR>';

echo '
<table width="100%" border="0">
';

$title_arr=array();
$title_arr[100] = $Language->getText('project_admin_ugroup', 'ug_name');
$title_arr[200] = $Language->getText('project_admin_editugroup', 'desc');
$title_arr[300] = $Language->getText('project_admin_ugroup', 'members');
$title_arr[400] = $Language->getText('project_admin_servicebar', 'del?');
ksort($title_arr);
echo "<tr class=\"boxtable\">\n";
foreach($title_arr as $title) {
    echo '  <td class="boxtitle">'.$title."</td>\n";
}
echo "</tr>\n";

$purifier = Codendi_HTMLPurifier::instance();

$ugroupRow = array();
$row_num   = 0;
$result    = db_query("SELECT * FROM ugroup WHERE group_id=100 ORDER BY ugroup_id");
while ($row = db_fetch_array($result)) {
    if ($row['name'] != 'ugroup_document_tech_name_key' && $row['name'] != 'ugroup_document_admin_name_key') {
        $ugroupRow[100] = $purifier->purify(util_translate_name_ugroup($row['name']).' *');
        $ugroupRow[200] = $purifier->purify(util_translate_desc_ugroup($row['description']));
        $ugroupRow[300] = array('value' => '-', 'html_attrs' => 'align="center"');
        $ugroupRow[400] = array('value' => '-', 'html_attrs' => 'align="center"');
        ksort($ugroupRow);
        format_html_row($ugroupRow, $row_num);
    }
}



if ($group_id != 100) {
  $result = db_query("SELECT * FROM ugroup WHERE group_id=$group_id ORDER BY name");
  if (db_numrows($result) > 0) {
    $ugroupUserDao = new UGroupUserDao();
    while ($row = db_fetch_array($result)) {
        $ugroupRow[100] = '<a href="/project/admin/editugroup.php?group_id='.$group_id.'&ugroup_id='.$row['ugroup_id'].'&func=edit">'.
            $purifier->purify(util_translate_name_ugroup($row['name'])).'</a>';
        $ugroupRow[200] = $purifier->purify(util_translate_desc_ugroup($row['description']));
        $res2=db_query("SELECT count(*) FROM ugroup_user WHERE ugroup_id=".$row['ugroup_id']);
        $nb_members=db_result($res2,0,0);
        if ($nb_members) {
            $ugroupRow[300] = array('value' => $nb_members, 'html_attrs' => 'align="center"');
        } else {
            $ugroupRow[300] = array('value' => 0, 'html_attrs' => 'align="center"');
        }
        $token =  $csrf->getTokenName().'='.$csrf->getToken();
        $link  = '?group_id='.$group_id.'&ugroup_id='.$row['ugroup_id'].'&func=delete&'.$token;
        $warn  = $Language->getText('project_admin_ugroup','del_ug');
        $alt   = $Language->getText('project_admin_servicebar','del');
        $ugroupRow[400] = html_trash_link($link, $warn, $alt);
        ksort($ugroupRow);
        format_html_row($ugroupRow, $row_num);
    }
  }
}

echo "</table>\n";
echo "<p>".$Language->getText('project_admin_ugroup','predef_g')."</p>\n";


project_admin_footer(array());
