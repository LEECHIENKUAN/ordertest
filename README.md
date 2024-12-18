# 資料庫測驗

## 題目一
請寫出一條 SQL 查詢語句，列出在 2023 年 5 月下訂的訂單，使用台幣 (TWD) 付款且 5 月總金 額最多的前 10 筆的 bnb_id、bnb_name，以及 5 月各旅宿總金額 (may_amount)。

```SQL
SELECT 
    o.bnb_id, 
    b.name,
    sum(o.amount) as may_amount

FROM 
    orders as o 
    LFET JOIN bnbs as b on (o.bnb_id = b.id)
WHERE
    o.currency = 'TWD' AND 
    o.created_at between '2023-05-01' and '2023-06-01'
GROUP by o.bnb_id 
ORDER BY may_amount DESC ;

```

## 題目二 
在題目一的執行下，我們發現 SQL 執行速度很慢，您會怎麼去優化?請闡述您怎麼判斷與優化 的方式

```shell 
我會用 explain 來分析SQL 指令的慢問題出現在那，根據表格及語法的設定，慢的原因有可能出現在 currency 這欄位上，因為用的是字串比對，解決方法，我會另建一個currency的表格用來存放貨幣的對應資料，再把名稱加上index，然後把orders.currency 欄位改成數值，那麼比對起來就會有比較大的改善效果。
```

---

# API 實作測驗 

## 題目一 
請用 Laravel 實作一個提供成立訂單的 API

## docker build 

```shell
docker build -t akuan/asiayo-app -f Dockerfile_ubuntu .
```

## docker run 
```shell
docker run --rm -d --name Asiayo-app -p 8080:80 akuan/asiayo-app
## dokcer run mount path and port 
docker run --rm -d --name Asiayo-app -v .:/var/www/html -p 8080:80 -p 3306:3306  akuan/asiayo-app

docker run -d --name Asiayo-app -v .:/var/www/html -p 8080:80 -p 3306:3306  akuan/asiayo-app

```

---

## 進入主機

```shell
docker run --rm -it --name Asiayo-app -p 8080:80 akuan/asiayo-app /bin/bash 

or 

docker run --rm -it {id} /bin/bash 
```

## MySQL 資料庫設定
``` shell
啟動
service mysql restart

＃修改root資料庫密碼
ALTER USER 'root'@'localhost' IDENTIFIED BY ‘1qaz2wsx’;

＃新增帳號及設定權限
CREATE USER 'asiayo'@'%' IDENTIFIED BY ‘asiayo@1217’;
CREATE USER 'asiayo'@'localhost' IDENTIFIED BY 'asiayo@1217';
GRANT ALL PRIVILEGES ON asiayo.* TO 'asiayo'@'%';
GRANT ALL PRIVILEGES ON asiayo.* TO 'asiayo'@'localhost';
FLUSH PRIVILEGES;

＃建立資料庫
CREATE DATABASE asayo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

``` 

## 進行 unit_test
```shell 
./vendor/bin/phpunit --filter OrderApiTest

結果

![測試結果](https://github.com/LEECHIENKUAN/ordertest/blob/main/test_res.png)

```

## SOLID 與設計模式

- **S**: 單一職責 (每個類別/功能專注於一個職責，例如 `FormRequest` 和 `Listener` 分離)。
- **O**: 開放封閉 (可以支持更多幣別，無需更改核心邏輯，只需新增資料表和對應處理)。
- **L**: 替換原則 (事件與監聽器的解耦設計)。
- **I**: 接口隔離 (FormRequest 對輸入進行檢查，與其他邏輯隔離)。
- **D**: 依賴反轉 (使用事件系統實現鬆耦合處理)。

---

# 架構測驗

題目一 如果由您來規劃線上通訊服務，您會怎麼設計?請提供您的設計文件，並敘述您的設計目標。

## 設計目標

- 高效溝通：提供快速且穩定的即時通訊體驗，確保訊息能即時傳遞。
- 跨平台支持：支援多種設備（桌面、手機、平板），提供一致的使用者體驗。
- 安全性與隱私保護：實現端對端加密，保護用戶的通訊內容及隱私。
- 多功能整合：整合文字、語音、視頻通話，以及文件共享功能。
- 擴展性：支援大量使用者同時使用，並易於後續新增功能。

## 核心功能

- 即時文字聊天
    1. 單人聊天和群組聊天功能。
    2. 支援圖片。
    3. 訊息已讀回報與打字中通知。
- 文件與媒體共享
    1. 上傳並分享圖片、視頻、文件等檔案。
    2. 支援檔案雲端儲存。
- 訊息加密與安全性
    1. 端對端加密保障訊息隱私。
    2. 驗證用戶身份的雙因素驗證（2FA）。

## 系統架構設計

- 前端架構
    1. 使用網頁技術 Javascript 實現跨平台應用。
    2. 使用 WebSocket 實現即時訊息推送。
- 後端架構
    1. 採用微服務架構，分別處理用戶管理、訊息處理、媒體存儲等功能模組。
    2. 使用 Node.js 或 Go 搭配高效能框架處理即時通信。
- 資料庫設計
    1. 使用 MongoDB 儲存聊天訊息，便於處理結構化及非結構化數據。
    2. 使用　MySQL　來儲存用戶的個人登入資料。
    3. Redis 作為快取，提升查詢與訊息傳遞速度。
- 安全性設計
    1. 使用 SSL/TLS 加密通信。
    2. 端對端加密協議，如 Signal Protocol。
- 可擴展性設計
    1. 利用 Kubernetes 實現容器化部署，支持動態擴展。
    2. 使用 CDN 提升媒體文件的分發速度。

## 測試與版本迭代計畫

- 功能測試：確保所有功能正常運作。
- 壓力測試：模擬大量用戶同時在線，檢測系統性能。
- 用戶反饋：根據用戶意見進行持續改進。

---

## postmain api 設定

檔案名為：Asiayo.postman_collection

---
