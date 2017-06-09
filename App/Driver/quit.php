<?php
//退出
session_start();
unset($_SESSION['username']);
$url = "../login.html";
Header("location: $url");