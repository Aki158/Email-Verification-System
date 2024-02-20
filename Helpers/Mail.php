<?php

namespace Helpers;

// composerの依存関係のオートロード
require_once 'vendor/autoload.php';

use Helpers\Settings;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public static function sendVerificationEmail(string $url, string $email): void{
        // 例外を有効にして PHPMailer を起動します。
        $mail = new PHPMailer(true);
        $username = Settings::env('MAIL_USERNAME');
        $password = Settings::env('MAIL_PASSWORD');
        

        try {
            // サーバの設定
            $mail->isSMTP();                                      // SMTPを使用するようにメーラーを設定します。
            $mail->Host       = 'smtp.gmail.com';                 // GmailのSMTPサーバ
            $mail->SMTPAuth   = true;                             // SMTP認証を有効にします。
            $mail->Username   = $username;                        // SMTPユーザー名
            $mail->Password   = $password;                        // SMTPパスワード
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // 必要に応じてTLS暗号化を有効にします。
            $mail->Port       = 587;                              // 接続先のTCPポート

            // 受信者
            $mail->setFrom($username, 'computer-parts application'); // 送信者設定
            $mail->addAddress($email); // 受信者を追加します。

            $mail->Subject = mb_encode_mimeheader('メールアドレスの確認','UTF-8');

            // HTMLコンテンツ
            $mail->isHTML(); // メール形式をHTMLに設定します。
            ob_start();
            include('Views/mail/templete.php');
            $mail->Body = ob_get_clean();

            // 本文は、相手のメールプロバイダーがHTMLをサポートしていない場合に備えて、シンプルなテキストで構成されています。
            ob_start();
            include('Views/mail/templete.txt'); // プレーンテキスト用のPHPファイル
            $mail->AltBody = ob_get_clean();

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}