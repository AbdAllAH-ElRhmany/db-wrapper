#  DbWrapper 

DbWrapper is a small php wrapper for mysql databases.

## installation

install once with composer:

```
composer require sqldb_Helper\DbWrapper
```

then add this to your project:

```php
require __DIR__ . '/vendor/autoload.php';
use sqldb_Helper\DbWrapper\DbWrapper;
$db = new DbWrapper();
```

## usage

```php
/* connect to database */
$db = new DbWrapper('127.0.0.1', 'username', 'password', 'database', 3306);

/* insert/update/delete */
$id = $db->insert('tablename', ['col1' => 'foo'])->excute();
$db->update('tablename', ['col1' => 'bar'])->where(['id' => $id])->excute();
$db->delete('tablename')->where(['id' => $id])->excute();

/* select */
$db->select('tablename','columns')->getAll();
$db->select('tablename','columns')->getRow();
$db->select('tablename','columns')->where(['id' => $id])->getRow();

$db->select('tablename','columns')->where(['id' => $id])->andWhere(['id' => $id])->getRow();

$db->select('tablename','columns')->where(['id' => $id])->orWhere(['id' => $id])->getRow();

```

