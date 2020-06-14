<?php 
require 'rb/rb.php';

R::setup('mysql:host=localhost;dbname=db_test','root','');
R::freeze(false);

if(!R::testConnection()){
	exit('нет подключения к БД');
}

function dump($value){
	echo '<pre>';print_r($value);echo'</pre>';
}

$user = R::dispense('user');
$user->name = 'valera';
$user->age = 27;

R::store($user); 

// load
echo '<h3>load</h3>';
$usersLoad = R::load('test', 1);
$usersLoad = $usersLoad->export(); //перевод в массив

dump($usersLoad['name']);
	

$id = [1,2,3];

// loadAll
echo '<h3>loadAll</h3>';
$users = R::loadAll('test',$id);

foreach($users as $user){
	echo ' name ' . $user->name;
	echo '<br />';
}

//find
echo '<h3>find</h3>';
$usersFind = R::find('test', 'WHERE `age` >= ? ORDER BY `age` ASC', array(20));

foreach($usersFind as $userFind){
	echo ' age ' . $userFind->age;
	echo ' name ' . $userFind->name;
	echo '<br />';
}

//findOne
echo '<h3>findOne</h3>';
$usersFindOne = R::findOne('test', 'WHERE `id` <= ?', array(3));

echo 'name ' . $usersFindOne->name;

//findAll
echo '<h3>findAll</h3>';
$usersFind = R::findAll('test', 'WHERE `age` >= ? ORDER BY `age` ASC', array(20));

foreach($usersFind as $userFind){
	echo ' age' . $userFind->age;
	echo ' name' . $userFind->name;
	echo '<br />';
}

//findCollection экономит производительность делая по одному запросу
echo '<h3>findCollection</h3>';
$usersFindCollection = R::findCollection('test', 'WHERE `id` > ?', array(0));

while($userFindCollection = $usersFindCollection->next()){
	echo $userFindCollection->name;
}

//findLike поиск по значению
echo '<h3>findLike</h3>';
$usersfindLike = R::findLike('test', array('name' => array('Valera', 'Tanya')), 'ORDER BY `age` ASC');

foreach($usersfindLike as $userfindLike){
	echo $userfindLike->name;
	echo '<br />';
}

//findOrCreate ищет в базе, если не находит создает новый
$userfindOrCreate = R::findOrCreate('test', array(
	'name' => 'Tatyana',
	'age' => 22,
	'city' => 'Krasnodar'
));

//count
$userscount = R::count('test', 'WHERE `age` >= ?', $age);

echo $userscount;


//UPDATE
$usersfindLike = R::findLike('test', array(
	'name' => $nameLike
));

foreach($usersfindLike as $userfindLike){
	$userfindLike->city ='Krasnodar';
}

//R::storeAll($usersfindLike);

//DELETE

$usersDelete = R::load('test', 1);
R::trash($usersDelete);

//exec 

$usersexec = R::exec("DELETE  FROM `test` WHERE `id` = ? ", array(3));

//getAll более оптимизированный запрос, getRow возращает первую строку, getCol возращает определенный столбец

//R::convertToBean('таблица', массив) R::convertToBeans('таблица', массив) для многомерного массива



//many to many
$personals = R::dispense('personals');
$personals->name = 'Игорь';
$positions = R::dispense('positions'); 
$positions->position = 'менеджер';
$personals->sharedTagList[] =$positions;


$positions = R::load('positions', 1);
$persona_position = $positions->sharedPersonalsList;
$persona_positions= $persona_position->export();
foreach($persona_position as $persona){
	echo $persona->name;
}

R::storeAll(array($personals ));

//one to many
//создать связь

$player = R::dispense('player');
$player->name ='Valera';

$player = R::load('player', 1);

$item = R::dispense('item');
$item->type = 'mobile';
$item->quantity = '100';

$player->ownItemList[] = $item;

R::store($player);

//показать предметы player

$player1 = R::load('player', 1);
$player1_items = $player1->ownItemList;

foreach($player1_items as $player1_item){
	if($player1_item->type === 'mobile'){
		$player1_mobile[] = $player1_item->id;
	}
}
$player2 = R::getCol("SELECT `id` FROM `player` WHERE `id` = ?", array(2));



R::exec("DELETE FROM `item` WHERE `id` IN(".genSlots($player1_mobile).") ", $player1_mobile); // удалить предмет при связи
R::exec("UPDATE `item` SET `player_id` = ?  WHERE `id` IN(".genSlots($player1_mobile).") ", $player1_mobile);//разорвать связь не удаляя
R::exec("UPDATE `item` SET `player_id` = ?  WHERE `player_id` IS NULL ", $player2); // добавить для определенного пользователя
$age = [20];
$nameLike = ['Valera', 'Tatyana'];
$bd_test = R::dispense('test');

$bd_test->name = 'Valera';
$bd_test->age = 24;
$bd_test->city = 'Krasnodar';





