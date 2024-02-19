<!DOCTYPE html>
<html>
    <head>
        <title>メールアドレスの確認</title>
    </head>
    <body>
    
    <p>こんにちは</p>
    <p>メールアドレスを確認するには、下のURLをクリックしてください</p>
    <a href="<?php echo $url ?>"><?php echo $url ?></a>

    <p>アカウントの作成にお心当たりが無い場合は、このメールを無視してください。</p>
    <p>よろしくお願い致します。</p>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> computer-parts application</p>
    </footer>
    </body>
</html>