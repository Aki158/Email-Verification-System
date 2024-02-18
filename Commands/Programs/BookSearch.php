<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;
use Database\MySQLWrapper;
use Exception;
use DateTime;

class BookSearch extends AbstractCommand
{
    // 使用するコマンド名を設定
    // コマンドの説明
    // php console book-search (num) --isbn isbnNum 

    protected static ?string $alias = 'book-search';

    // 引数を割り当て
    public static function getArguments(): array
    {
        return [
            (new Argument('isbn'))->description('Set isbn.')->required(false)->allowAsShort(true),
        ];
    }

    public function execute(): int
    {
        $isbnNum = $this->getArgumentValue('isbn');
        $isbnKey = 'book-search-isbn-'.$isbnNum;
        $url = "https://openlibrary.org/api/books?bibkeys=ISBN:".$isbnNum."&format=json";
        $data = $this->callOpenLibraryAPI($url);
        $info_url = $data['ISBN:'.$isbnNum]['info_url'];
        $date_string = date('Y-m-d');
        
        $mysqli = new MySQLWrapper();

        // booksテーブルが無ければ作成する
        $create_table = $mysqli->query('CREATE TABLE IF NOT EXISTS books(id INT PRIMARY KEY  AUTO_INCREMENT,  isbnKey VARCHAR(50), info_url VARCHAR(255), created_at DATE, update_at DATE)');

        $result = $mysqli->query('SELECT * FROM books');

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $old_date = new DateTime($row['update_at']);
                $now_date = new DateTime($date_string);
                $interval = $now_date->diff($old_date);
                $days = $interval->days;

                // booksテーブルの中にキーがある
                if($isbnKey === $row['isbnKey']){
                    if($days < 30){
                        // APIを叩かずprint()出力する
                        $this->log("isbn existed in the books table.");
                    }
                    else{
                        // APIを叩いてテーブルを更新する
                        $stmt = $mysqli->prepare("UPDATE books SET info_url = ? , update_at = ? WHERE isbnKey = ?");
                        $stmt->bind_param("sss", $info_url, $date_string, $isbnKey);
                        $update_table = $stmt->execute();
                        $stmt->close();

                        $this->log("Updated books table.");
                    }
                    $this->log("url : ".$info_url);
                    return 0;
                }
            }
        }
        // キーがない
        // APIを叩きデータを取得する
        // APIのデータをbooksテーブルに設定する
        $stmt2 = $mysqli->prepare("INSERT INTO books(isbnKey , info_url , created_at, update_at) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("ssss", $isbnKey, $info_url, $date_string, $date_string);
        $set_table = $stmt2->execute();
        $stmt2->close();


        $this->log("Inserted data into books table.");
        $this->log("url : ".$info_url);
        return 0;
    }

    public function callOpenLibraryAPI($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
    
}