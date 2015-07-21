<?php

/* Don't confuse anything at the seeding level, but using
 * composer and PSR* would be much nicer */
require('Seeders/UserSeeder.php');

$UserSeeder = new UserSeeder($this);

$UserSeeder->run();
