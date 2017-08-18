<!-- DO NOT EDIT THIS FILE; it is auto-generated from readme.txt -->
# Wp Tide Test Plugin

**Contributors:** [xwp](https://profiles.wordpress.org/xwp)  
**License:** [GPLv2 or later](http://www.gnu.org/licenses/gpl-2.0.html)   

## Description ##

Plugin for testing wp-tide.

1. Master branch contains the good code, and should give 100% score in audit.

## Useful Commands ##

Only get the sniff list.

``
phpcs fileName -s | ack -o '(?<=\()\w+(\.\w+)+(?=\)$)' | sort | uniq -c | sort -nr
``