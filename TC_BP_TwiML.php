<?php
header('Content-type: text/xml');
 
// 発信者番号：Twilioから取得された電話番号
$callerId = "your twilio tel number";
// 受信者番号：Twilioの電話番号に電話をかけた際に受信者としてTwilio Client名を設定。（番号でも問題ない）
$number = "your twilio client name";

// 画面から入力された電話番号の取得
if (isset($_REQUEST['PhoneNumber'])) {
	$number = $_REQUEST['PhoneNumber'];
}

// 発信先が番号かClient名かを判別し、発信先を設定する。
if (preg_match("/^[\d\+\-\(\) ]+$/", $number)) {
    $numberOrClient = "<Number>" . $number . "</Number>";
} else {
    $numberOrClient = "<Client>" . $number . "</Client>";
}
?>

<Response>
    <Say language="ja-jp">Twilio Clientから電話をかけます。</Say>
    <Dial callerId="<?php echo $callerId ?>">
        <?php echo $numberOrClient ?>
    </Dial>
    <Say language="ja-jp">通話が終了致しました。</Say>
</Response>