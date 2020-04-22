if (!isset($_REQUEST)) {return;}
// Строка, которую должен вернуть сервер (См. Callback API->Настройки сервера)
$confirmationToken = '8064359a';
// Ключ доступа сообщества (длинная строчка которую получили нажав "создать ключ")
$token = '072b0a909c47f6b033175526944183e585f4a61d81b082d9de1ec3242453890e72cdb77f72e39bc5a13ef';
// Секретный ключ. (Задаем в Callback API->Настройки сервера)
$secretKey = 'k';
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
        if ($mes=='Начать') {
        $answ='Начать ты написал зачем';
        }
// Через messages.send используя токен сообщества отправляем ответ
$request_params = array(
'message' => "$answ",
'user_id' => $userId,
'access_token' => $token,
'v' => '5.50'
);
    
$get_params = http_build_query($request_params);
file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
echo('ok'); // Возвращаем "ok" серверу Callback API
break;
}
?>
