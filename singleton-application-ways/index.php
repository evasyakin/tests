<?php
/**
 * Сравнение реализаций синглтона приложения.
 * @author Egor Vasyakin <egor@evas-php.com>
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'AppInstance.php';
include 'AppExtendsStaticDi.php';
include 'AppWithDi.php';
include 'AppInstanceTests.php';

new AppInstanceTests('AppInstance', 'AppWithDi', 'AppExtendsStaticDi');
