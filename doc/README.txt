liseventsearch
==============

provides a extendend attribute filter for template fetch function.
searches in 2 datefields from one class if start/stop date matches the stored object attributes 

ezversions : 3.10.x ,should work with other versions also

Installation:
- upload extension 
- activate extension
- use filter in template fetch


example:
{def $events=fetch( 'content', 'tree',
	        hash( 'parent_node_id', $node.node_id,
	              'sort_by', array( 'attribute', true(), 'event_2/start_date' ),
	              'limit', 15,
	  			  'extended_attribute_filter',
	                            hash( 'id', 'lisEventSearch',
	                            'params', hash( 'start_attribute', 'event_2/start_date',
	                                          'stop_attribute', 'event_2/end_date',
	                                          'start', $tmp_start,
	                                          'stop', $tmp_stop) )
	              ) )}

parameters:  
start_attribute => classattribute identifier. id or class/attribute 
stop_attribute =>  classattribute identifier. id or class/attribute
start => timestamp
stop  => timestamp
if no start or stop stamps are provided, it searches for today + 30 days.

Changelog
=========
v.0.1 Initial Relase