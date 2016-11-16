<?php
session_start();

// Sypex Dumper находится в ./vendor/sxd/
require '../../system/engine/registry.php';
require '../../system/library/db.php';
require '../../system/library/user.php';
require '../../system/library/request.php';
require '../../system/library/session.php';
require '../../admin/config.php';

$registry = new Registry();

$registry->set('db', new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE));
$registry->set('request', new Request());
$registry->set('session', new Session());

/*
 * Если существует $_SESSION['user_id'] - происходит выборка данных о данном
 * пользователе. Происходит получение списка прав по той группе, в которую входит
 * данный пользователь.
 */
$user = new User($registry);

/*
 * Если у данного пользователя есть права на доступ к меню в админке OpenCart
 * Система -> Бэкап/Восстановление, значит, логично предположить, можно
 * эти права применить для доступа и к данному модулю
 */
if ($user->isLogged() AND $user->hasPermission('access', 'tool/backup') AND $user->hasPermission('modify', 'tool/backup'))
{
    $this->CFG['my_user'] = DB_USERNAME;
    $this->CFG['my_pass'] = DB_PASSWORD;
    $this->CFG['my_db']   = DB_DATABASE;
    $this->CFG['my_host'] = DB_HOSTNAME;

    $auth = 1;
}
else
{
    $auth = 0;
}
?>
