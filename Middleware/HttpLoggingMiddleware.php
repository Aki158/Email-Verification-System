<?php

namespace Middleware;

use Response\HTTPRenderer;

class HttpLoggingMiddleware implements Middleware {
    private $logFileType = 'file';
    private $logFilePath = 'httpLog.log'; // ログファイルのパスを指定

    public function handle(callable $next): HTTPRenderer {
        $protocol= isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = $protocol.$host.$uri;
        $requestHeaders = "";

        foreach(getallheaders() as $key => $value){
            $requestHeaders .= "\n\t".$key." : ".$value;
        }

        // リクエストの詳細を記録
        $requestDetails = sprintf(
            "■ リクエスト\nURL : %s\nリクエストメソッド : %s\nタイムスタンプ : %s\nクエリパラメータ : %s\nリクエストヘッダー : %s\n",
            $url,
            $_SERVER["REQUEST_METHOD"],
            $_SERVER["REQUEST_TIME"],
            $_SERVER["QUERY_STRING"],
            $requestHeaders
        );

        if($this->logFileType === "stdout"){
            error_log($requestDetails);
        }
        else if($this->logFileType === "file"){
            file_put_contents($this->logFilePath, $requestDetails, FILE_APPEND);
        }
        else if($this->logFileType === "db"){
            // .envのDATABASE_DRIVERの値によってmysqlまたはmemcacheのどちらかにログを保存する
        }

        // 次のミドルウェアまたはリクエストハンドラーを実行
        $response = $next();

        // PHPのビルトインサーバーでは、file_get_contents()やcurl()が使用できなかった。
        // 調べた際に、ネットの記事によく書かれていた、「php.iniのallow_url_fopen=Onにすること」は設定済。
        // そのため、下記のように対応することにした。
        // ・PHPのビルトインサーバー : ダミーデータをログに出力する
        $responseHeaders = "\n\tダミーデータ\n\tHTTP/1.1 200 OK\n\tDate: Sun, 11 Feb 2024 08:49:03 GMT";

        // ・上記以外 : file_get_contents()と$http_response_headerを使用しレスポンスヘッダー情報を出力する
        // file_get_contents($url);
        // $responseHeaders = "";
        // foreach($http_response_header as $value){
        //     $responseHeaders .= "\n\t".$value;
        // }

        // レスポンスの詳細を記録
        $responseDetails = sprintf(
            "■ レスポンス\nレスポンスヘッダー : %s\n",
            $responseHeaders
        );

        if($this->logFileType === "stdout"){
            error_log($responseDetails);
        }
        else if($this->logFileType === "file"){
            file_put_contents($this->logFilePath, $responseDetails, FILE_APPEND);
        }
        else if($this->logFileType === "db"){
            // .envのDATABASE_DRIVERの値によってmysqlまたはmemcacheのどちらかにログを保存する
        }
        
        return $response;
    }
}
