<?php
if (!isset($_REQUEST)) {return;}
// Строка, которую должен вернуть сервер (См. Callback API->Настройки сервера)
$confirmationToken = '9b510470';
// Ключ доступа сообщества (длинная строчка которую получили нажав "создать ключ")
$token = '659d3687f664f8590731be425ae93f42b2c865e7d67868b80049cf09068a6b221ec7d326dc503135fe80c';
// Секретный ключ. (Задаем в Callback API->Настройки сервера)
$secretKey = 'aaH';
// Получаем и декодируем уведомление
$data = json_decode(file_get_contents('php://input'));
// проверяем secretKey
if (strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0) {return;}
// Проверяем, что находится в поле "type"
switch ($data->type) {
// Запрос для подтверждения адреса сервера (посылает ВК)
case 'confirmation':
echo $confirmationToken; // отправляем строку для подтверждения адреса
break;
// Если это уведомление о новом сообщении...
case 'message_new':
// получаем id автора сообщения
$userId = $data->object->user_id;
    $mes = $data->object->body;
             $uinfo=file_get_contents("https://api.vk.com/method/users.get?user_ids=$userId&access_token=659d3687f664f8590731be425ae93f42b2c865e7d67868b80049cf09068a6b221ec7d326dc503135fe80c&v=5.103");
$uinfo=json_decode($uinfo,1);
        $answ="Прости, ".$uinfo["response"][0]['first_name'].", я не знаю такой команды. Напиши coms"; 
 if ($mes=="Начать") {
$answ="Привет, [id".$userId."|".$uinfo["response"][0]['first_name']."]! Рады видеть тебя в нашем паблике. Напиши coms"; 
 }
 if ($mes=="coms" || $mes=="Coms") {
$answ="Вот список команд:\n employes - список сотрудников паблика\ndurka - если честно, я фиг знает что делает эта команда\nNick_gen: [phrase] - сгенерировать никнейм из фразы. Бот не придумывает вам гениальный и хорошо выглядящий никнейм, он просто звменяет некоторые символы, но попробовать можно. Пример: 'nick_gen: Killer'\nЕсли у тебя вопрос, напиши 'q: ' и дальше напиши свой вопрос, например q: хто я?";
 }
      if ($mes=="Employes" || $mes=="employes") {
     $answ="Создатель - @nikitaomg (Никита Сысоев)\nАдминистратор - @vvediteima (Платонов Егор)\n Мемодел - @buterbruuh (Максим Кавцов)"; 
      }
        if ($mes=="Durka" || $mes=="durka") {
      $answ="Ухх... Шиза( Тебе сюда - https://vk.cc/9ZmxRb";  
        }
        $x=explode(": ",$mes);
        if ($x[0]=="q" || $x[0]=="Q") {
        $request_params = array(
'message' => "@id$userId - $mes",
'user_id' => 345283375,
'access_token' => $token,
'v' => '5.0'
);
    
$get_params = http_build_query($request_params);
file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
            $answ="Ваш вопрос принят, скоро администратор ответит вам в Личных сообщениях";
        }
       if ($x[0]=="nick_gen" || $x[0]=="Nick_gen") {
$nick=$x[1];
$nick=str_replace("a","4",$nick);
$nick=str_replace("а","4",$nick);
$nick=str_replace("l","1",$nick);
$nick=str_replace("o","0",$nick);
$nick=str_replace("о","0",$nick);
$nick=str_replace("s","5",$nick);
$nick=str_replace("r","г",$nick);
$nick=str_replace("10","1o",$nick);
$nick=str_replace("14","1a",$nick);
$nick=str_replace("л4в","L0ve",$nick);
$nick=str_replace("l4v","L0ve",$nick);
$answ=$nick;
}
        
// Через messages.send используя токен сообщества отправляем ответ
$request_params = array(
'message' => $answ,
'user_id' => $userId,
'access_token' => $token,
'v' => '5.0'
);
    
$get_params = http_build_query($request_params);
file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
        echo "ok";
break;
}
?>
