<?php
file_put_contents(__DIR__.'/0.txt', print_r($_GET, 1), 8);

echo 'success';