<?php
require 'vendor/autoload.php';

use Core\Logic\Test\GetProduct;
use Spatial\MediatR\Mediator;


$mediator = new Mediator();
$r = $mediator->process(new GetProduct);

var_dump($r);
