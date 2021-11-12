
## File Structure

demo.php  (Load the project by using demo.php)
Lib/Predis.php  (Initialize the redis as singleton)
Lib/Tool.php   (Invoke data tools)

## Invoke data method

Firstly add include_once to import Tool.php
(new Tool())->index('','','')
First parameter is `origin`   
Second parameter is `destination`
Third parameter is `transport mode`
