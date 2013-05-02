<?
/*
* @copyright Copyright (C) 2010-2013 land in sicht AG All rights reserved.
* @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
*/
class lisEventSearchFilter
{
    /*!
     Constructor
    */
    function lisEventSearchFilter()
    {
        // Empty...
    }

    function createSqlParts( $params )
    {
        if (!isset($params['start_attribute']) || !isset($params['stop_attribute'])) 
        {
           return array( 'tables' => "", 'joins' => "" );
        }
        
        $start_class_attribute = $params['start_attribute'];
        if ( !is_numeric( $start_class_attribute ) )
         $start_class_attribute = eZContentObjectTreeNode::classAttributeIDByIdentifier( $start_class_attribute );
        $stop_class_attribute = $params['stop_attribute'];
        if ( !is_numeric( $stop_class_attribute ) )
         $stop_class_attribute = eZContentObjectTreeNode::classAttributeIDByIdentifier( $stop_class_attribute );
        
        $sqlTables= ', ezcontentobject_attribute as lis_start, ezcontentobject_attribute as lis_stop';
 
        $sqlJoins = ' ezcontentobject_tree.contentobject_id = lis_start.contentobject_id AND ezcontentobject_tree.contentobject_version = lis_start.version AND lis_start.contentclassattribute_id = "'.$start_class_attribute.'"  AND';
        $sqlJoins .= ' ezcontentobject_tree.contentobject_id = lis_stop.contentobject_id AND ezcontentobject_tree.contentobject_version = lis_stop.version AND lis_stop.contentclassattribute_id = "'.$stop_class_attribute.'"  AND';
        
        if ( isset( $params['start'] ) )
        {
             $start = $params['start'];
        }
        else
        {
             $start = mktime();
        }
        if ( isset( $params['stop'] ) )
        {
             $stop = $params['stop'];
        }
        else
        {
             $stop = mktime() + (86400 * 30);
        }
        
//        eZDebug::writeNotice("start", date("Y-m-d", $start));
//        eZDebug::writeNotice("stop", date("Y-m-d", $stop));
        
        
        $sqlCondArray = array();
 
        $sqlCondArray[] = '(lis_start.data_int >= "' . $start . '" AND lis_start.data_int <= "' . $stop . '")';
        $sqlCondArray[] = '(lis_stop.data_int >= "' . $start . '" AND lis_stop.data_int <= "' . $stop . '")';
        $sqlCondArray[] = '(lis_start.data_int <= "' . $start . '" AND lis_stop.data_int >= "' . $stop . '")';
        
        $sqlCond = implode( ' or ', $sqlCondArray );
 
        $sqlCond = ' ( ' . $sqlCond . ' ) AND ' . $sqlJoins . ' ';
 
        return array( 'tables' => $sqlTables, 'joins' => $sqlCond );
 
    }

}
?>