Simple PDO MySQL Wrapper Class
==============================

This is a simple class for providing a simple API to the PDO MySQL
database driver.

It relies on all tables in your database having a column called `id` which
is typically a `serial` type (`bigint(20) unsigned auto_increment`). This
column is used to select individual records within a table.

Usage
-----

1. Create an object:

    $db = new \Majenkotech\DB("username", "password", "hostname", "database");

2. Execute a query with optional embedded arguments:

    $q = $db->query("SELECT name,size FROM something WHERE foo=:bar AND baz=:fod",
        array(
            "bar" => 23,
            "fod" => "beep"
        )
    );

3. Use `$db->nextRecord($q)` to get successive record objects:

    while ($r = $db->nextRecord($q)) {
        print "$r->name is $r->size\n";
    }

Other useful functions
----------------------

* Insert a new record into a table:

    $id = $db->insert("tablename", array(
        "field1" => "value",
        "field2" => value,
        ... etc ...
    ));

* Get ID of last inserted record:

    $id = $db->id();

* Update a record in a table:

    $db->update("table", $id, array(
        "field1" => "value",
        "field2" => value,
        ... etc ...
    ));

* Select a record by ID:

    $r = $db->select("tablename", $id);

* Set a single value in a record in a table:

    $db->set("table", $id, "field", "value");
