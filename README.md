### ApnsPHPをphp5.2で動かすための変更


- `php5.2` では `json_encode` が引数1つしか取れないため
 - https://github.com/masuhajime/20150917_apns_push/commit/27dea0b2e6382da9e503a9907e1f1a1dea67beba


### SJISでpushするために文字コードをUTF-8にする

ファイルの文字コードは `SJIS` ですが  
`Apns` に送る文字コードは `UTF8` である必要があります  
https://github.com/masuhajime/20150917_apns_push/blob/master/ApnsMessageSender.php#L41

### Apnsにpushする際の問題


1.1つのメッセージで `256` バイトを超えてはいけない
1.1回の通信で全パケットが` 5000〜7000` バイトを超えるとAPNSから切断される


- 上記2つの問題に対しての対策
 - それらの対策が入っているApnsPHPに任せる
- メッセージ間のsleep
 - https://github.com/immobiliare/ApnsPHP/blob/master/ApnsPHP/Push.php#L184
- エラーで切断された後の再接続処理
 - https://github.com/immobiliare/ApnsPHP/blob/master/ApnsPHP/Push.php#L346-L358
- 手元のiOS端末に4096byte以上のメッセージを20件連続で送る → 全て確認できた

### 参考

- `entrust_root_certification_authority.pem` と `server_certificates_sandbox.pem` を  
作成するために参考にした記事
 - https://akira-watson.com/iphone/push-notification_1.html
- http://liginc.co.jp/programmer/archives/2355
- https://github.com/immobiliare/ApnsPHP



https://github.com/masuhajime/20150917_apns_push/commit/27dea0b2e6382da9e503a9907e1f1a1dea67beba
