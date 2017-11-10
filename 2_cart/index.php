<?php

/*
Author dwi.setiyadi@gmail.com
Made for Sirclo
*/

require('config.php');
require('cart.php');
Cart::installProductTable();

Cart::add("Baju Merah Mantap", 1);
Cart::add("Baju Merah Mantap", 1);
Cart::add("Bukuku", 3);
Cart::remove("Bukuku");
Cart::add("Singlet Hijau", 1);
Cart::remove("ProdukBohongan");
Cart::show();

/* end of file */