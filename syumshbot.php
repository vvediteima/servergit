<?php
if (!isset($_REQUEST)) {return;}
// Строка, которую должен вернуть сервер (См. Callback API->Настройки сервера)
$confirmationToken = '616406a0';
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
 if ($mes=="Начать") {
$answ="Привет, [id".$userId."|".$uinfo["response"][0]['first_name']."]! Рады видеть тебя в нашем паблике. Напиши b:coms"; 
 }
 /*if ($mes=="b:coms" || $mes=="B:coms") {
$answ="Вот список команд:\n•b:Employes - список сотрудников паблика\n";
 }
      if ($mes=="b:employes" || $mes=="B:employes") {
     $answ="Создатель - @nikitaomg (Никита Сысоев)\nАдминистратор - @vvediteima (Платонов Егор)\n Мемодел - @buterbruuh (Максим Кавцов)";
      }*/
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
