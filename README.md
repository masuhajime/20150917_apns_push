### Apnsにpushする際の問題


1.1つのメッセージで256バイトを超えてはいけない
2.1回の通信で全パケットが5000〜7000バイトを超えるとAPNSから切断される


- 上記2つの問題に対しての対策
 - それらの対策が入っているApnsPHPに任せる
- メッセージ間のsleep
 - https://github.com/immobiliare/ApnsPHP/blob/master/ApnsPHP/Push.php#L184
- エラーで切断された後の再接続処理
 - https://github.com/immobiliare/ApnsPHP/blob/master/ApnsPHP/Push.php#L346-L358
- 手元のiOS端末に4096byte以上のメッセージを20件連続で送る → 全て確認できた

### 参考

- http://liginc.co.jp/programmer/archives/2355
- https://github.com/immobiliare/ApnsPHP