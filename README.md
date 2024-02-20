# Email-Verification-System
📩コンピュータ部品アプリケーション(メール検証システムによる拡張)

## 📝説明
このアプリケーションは、コンピュータ部品アプリケーションです。

[Recursion](https://recursionist.io/)のServers with Databasesコースで提供されたソースコードをもとにメール検証システムを拡張したものになります。

このアプリケーションでは、ユーザーが登録したコンピュータ部品を見ることができます。

コンピュータには、どのような部品が使われているのか把握することで、ユーザーが1からコンピューターを自作する場合などに役立ちます。

表示されるコンピュータ部品は、偽データがほとんどのため、実際には存在しないものもあることに注意してください。

基本的な機能として、以下のような機能を提供します。

- ユーザー登録
- ログイン
- ログアウト
- メール検証システム
- コンピュータ部品の表示、登録、更新

多くの機能を実装していますが、このREADMEには、メール検証システムについてのみ記載します。

代わりに、今後作成予定の Social-Networking-Service に機能の一部としてメール検証システムを実装する予定です。

## 🚀メール検証システム

メール検証システムのイメージは、下記ユースケース図の通りです。

![image](https://github.com/Aki158/Email-Verification-System/assets/119317071/8dc1a888-d6cd-4ac9-af3e-c21b1f6e6957)

1. ユーザーは、`register`ページでユーザー登録ができます。
2. ユーザーが入力を完了すると、その情報は、`form/register`ルートへ送られます。<br>ここでは、ユーザー情報をデータベースに登録し入力されたメールアドレスへ署名付きのURLを添えたメールを作成します。<br>署名付きのURLは、以下のような形式のURLになります。<br>userとsignatureパラメータはハッシュ化されている必要があります。<br>`https://yourdomain.com/verify/email?id=434554&user=179e9c6498071768e9c6dcb606be681b35ec39d7c1cd462af5eee998793de96a&expiration=1686451200&signature=dc6f3568745f317e0227956332b7845187a8f6b6b46f1b21e533957454cd11d9`
3. アプリケーションからユーザーのメールアドレスへメールを送信します。
4. ユーザーは、`Email`に受信されたメールを確認します。
5. ユーザーが署名付きのURLにアクセスすると、URLを検証します。<br>検証は、ミドルウェアと`verify/email`ルートで行われます。<br>URLが改竄されていないか、期限切れでないかを確認します。<br>問題がなければ、usersテーブルの`email_confirmed_at`に検証した時間を更新します。
6. 検証に成功すると、`update/part`にアクセスできるようになります。
7. 未検証でサインインしたユーザーが`update/part`にアクセスした場合は、`verify/resend`ページにリダイレクトされます。<br>`form/verify/resend`では、入力された情報をもとにユーザーのメールアドレスへの新しい検証メールの送信やメールアドレスの変更ができます。

メール検証システムに関係するファイルは、下記から確認することができます。

| ファイル | 変更点 |
| ------- | ------- |
| [Database/DataAccess/Implementations/UserDAOImpl.php](https://github.com/Aki158/Email-Verification-System/blob/main/Database/DataAccess/Implementations/UserDAOImpl.php) | update関数追加 |
| [Database/DataAccess/Interfaces/UserDAO.php](https://github.com/Aki158/Email-Verification-System/blob/main/Database/DataAccess/Interfaces/UserDAO.php) | update関数追加 |
| [Helpers/Authenticate.php](https://github.com/Aki158/Email-Verification-System/blob/main/Helpers/Authenticate.php) | isVerificationEmail関数追加 |
| [Helpers/Mail.php](https://github.com/Aki158/Email-Verification-System/blob/main/Helpers/Mail.php) | ファイル追加 |
| [Middleware/AuthenticatedMiddleware.php](https://github.com/Aki158/Email-Verification-System/blob/main/Middleware/AuthenticatedMiddleware.php) | `else if(!Authenticate::isVerificationEmail())`処理追加 |
| [Middleware/GuestMiddleware.php](https://github.com/Aki158/Email-Verification-System/blob/main/Middleware/GuestMiddleware.php) | `if(Authenticate::isVerificationEmail()){...}else{...}`処理追加 |
| [Routing/routes.php](https://github.com/Aki158/Email-Verification-System/blob/main/Routing/routes.php) | ■ 処理追加<br>・`register`<br>■ルート追加<br>・`verify/email`<br>・`verify/resend`<br>・`form/verify/resend` |
| [Views/component/navigator.php](https://github.com/Aki158/Email-Verification-System/blob/main/Views/component/navigator.php) | `Resend`のリンク追加 |
| [Views/mail/templete.php](https://github.com/Aki158/Email-Verification-System/blob/main/Views/mail/templete.php) | ファイル追加 |
| [Views/mail/templete.txt](https://github.com/Aki158/Email-Verification-System/blob/main/Views/mail/templete.txt) | ファイル追加 |
| [Views/page/send-verification-email.php](https://github.com/Aki158/Email-Verification-System/blob/main/Views/page/send-verification-email.php) | ファイル追加 |
