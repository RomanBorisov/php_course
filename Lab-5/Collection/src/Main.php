<?php
declare(strict_types=1);

namespace App;

require_once '..\vendor\autoload.php';

//$myArray = new ArrayCollection(['nine' => 9, -2, -2, -1, 11, 2, 2, 3, 4, 3, 4, 5, 6]);
//
//$isPositive = function ($item) {
//    return $item > 0;
//};
//
//$plusThree = function ($item) {
//    return $item + 3;
//};
//
//
//$myArray->filter($isPositive)->map($plusThree)->print()->sort(true)->print()->unique()->print()->slice(2)->print()->isKeyExist(1);
//print_r($myArray->containsLeastOne(function ($item) {
//    return $item === 11;
//}));



/** WORKERS EXAMPLE */

class Worker
{
    public function __construct($name, $secondName)
    {
        $this->name = $name;
        $this->secondName = $secondName;
    }

    var $name;
    var $secondName;
}

$workers = new ArrayCollection([
    'third_worker' => new Worker('Sergey', 'Sergeev'),
    'first_worker' => new Worker('Ivan', 'Timofeev'),
    'fourth_worker' => new Worker('Sergey', 'Nikolaev'),
    'second_worker' => new Worker('Petr', 'Petrov'),
    'fifth_worker' => new Worker('Sergey', 'Block'),
    'sixth_worker' => new Worker('Petr', 'Petrov'),
]);


//$workers->sortBy(function (Worker $x) {
//    return $x->secondName;
//}, false);

$workers->groupBy(function (Worker $x) {
    return $x->name;
})['Sergey']->print();



