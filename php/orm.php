<?

// This scripts sets up the database connection and the orm

// We use the RedBean PHP ORM
require_once 'RedBeanPHP2_1_1/rb.php';

// Transparently use the local configuration, if present
$localIni = '../htdocs_conf/mysql_local.ini';
if (file_exists($localIni)) {
	$conf = parse_ini_file($localIni);
} else {
	$conf = parse_ini_file('conf/mysql.ini');
}
R::setup('mysql:host='. $conf['host']. ';dbname='. $conf['database']. '', $conf['user'], $conf['password']);
R::freeze(false); // If we're done developing, turn this to false. Stops changing the schema.
R::debug(false); // Turn on to show all queries on the screen

// Manual: http://www.redbeanphp.com/manual/
// API: http://www.redbeanphp.com/api/

/*
 * Excerpt of RedBen-ORM-API
 * 
 * R::dispense('book') // create
 * list($first, $second, ...) = R::dispense('book', 10) // create (multiple)
 * R::store($book) // save to db (returns $id)
 * R::load('book', $id) // load based on id
 * R::batch('book', array($id1, $id2)) // load batch of ids
 * R::trash($book) // Delete object from db
 * R::wipe('book') // Delete all such objects
 * 
 * Nested beans - property-name HAS to match the type of the bean!!
 * Array as parameter - parameter MUST be named ownXyz (contains xyz-beans) or sharedXyz
 * Fields with arbitrary names have to be resolved when loading:
 * $teacher = $project->fetchAs('person')->teacher;
 * 
 * associate two types:
 * R::associate($typeA, $typeB)
 * R::related(
 * 
 * R::swap($books, 'propertyname') // books is array of 2 objects. Exchange their propertyname-values.
 * 
 * $bean->getMeta('property.name'(, $defaultValue)) // Gets meta-info
 * $bean->setMeta('property.name', $value) // Sets meta-info
 * $bean->import($anArray) // imports all values in the array into the object. E.g. $_POST.
 * $bean->export() // returns copy of all data in an array
 * R::exportAll($beans (, true/false )) // optional second parameter: recursive (with infinite recursion protection)
 * 
 * R::find('book') // Return all
 * R::find('book', $query) // Query without wildcards
 * R::find('book', $query, $queryValues) // Query with wildcards
 * query: sql-get-query (without the 'where'); can contain question-marks or labels (:labelname)
 * queryValues: numbered values get filled into the querstion marks. named values replace the labels in the query.
 * R::findOne(...) // returns just the first
 * R::find('needle',' id IN ('.R::genSlots($ids).') ',$ids); // genSlots for less code
 * 
 * R::tag($bean(, $setvalues)) // $setvalues is comma-separated string or array; if absent, returns all tags for $bean
 * explode( ',', R::tag($page) ) // turns the returned comma-darated string to an array
 * R::untag($bean, $taglist) // delete a tag
 * R::hasTag($bean, $tags, $all=false) // returns true/false
 * R::tagged($beanType, $taglist) // returns all tagged objects
 * R::addTags($bean, $taglist) // adds tags without removing old (like tag())
 * 
 * Queries:
 * R::exec
 * R::getAll
 * R::getRow
 * R::getCol
 * R::getCell
 * Need 1 parameter (the sql query) + one optional to replace wildcards
 * 
 * Default meta fields:
 * type - holds the type of the bean ('book')
 * tainted - contains true, if the object has been changed
 * 
 * setup alternatives:
 * R::setup('mysql:host=localhost;dbname=mydatabase','user','password'); //mysql
 * R::setup('pgsql:host=localhost;dbname=mydatabase','user','password'); //postgresql
 * R::setup('sqlite:/tmp/dbfile.txt','user','password'); //sqlite
*/

?>
