<?php

$connection = new mysqli('localhost',  'root', 'password', 'in_out_calculator');
if ($connection->connect_error) die("Fatal Error");

