<?php
file_put_contents(__DIR__.'/0.txt', print_r(json_decode($_POST['game']), 1));