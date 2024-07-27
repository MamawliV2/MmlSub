    <?php
    ///   اوپن کردن این سورس باعث اشنا شدن شما با پدر اصلی تان است ///
////    نوشته شده توسط : @i_tekin///
    #-----------------------------#
    $token  = "7138290001:AAFCHHwg7JBdzO4et7dxPpOwIrUu0vI6mFA"; //Token
    $dev    = "1429423697"; // admin1
    $admin  = "1429423697"; // adminu2
    define('API_KEY', $token);
    #-----------------------------#
    $update = json_decode(file_get_contents("php://input"));
    if (isset($update->message)) {
        $from_id    = $update->message->from->id;
        $chat_id    = $update->message->chat->id;
        $tc         = $update->message->chat->type;
        $text       = $update->message->text;
        $first_name = $update->message->from->first_name;
        $message_id = $update->message->message_id;
    } elseif (isset($update->callback_query)) {
        $chat_id    = $update->callback_query->message->chat->id;
        $data       = $update->callback_query->data;
        $query_id   = $update->callback_query->id;
        $message_id = $update->callback_query->message->message_id;
        $in_text    = $update->callback_query->message->text;
        $from_id    = $update->callback_query->from->id;
    }
    #-----------------------------#
    function bot($method, $datas = [])
    {
        $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
        $res = curl_exec($ch);
        if (curl_error($ch)) {
            var_dump(curl_error($ch));
        } else {
            return json_decode($res);
        }
    }
    #-----------------------------#
    function sendmessage($chat_id, $text, $keyboard = null)
    {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => "HTML",
            'disable_web_page_preview' => true,
            'reply_markup' => $keyboard
        ]);
    }
    #-----------------------------#
    function editTextMessage($chat_id, $message_id, $new_text, $keyboard = null)
    {
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => $new_text,
            'parse_mode' => "HTML",
            'disable_web_page_preview' => true,
            'reply_markup' => $keyboard
        ]);
    }
    #-----------------------------#
    function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }
    function getPayLink($amount) {

        $requestAmount = $amount * 100 / 112;

        $data = array(
            'key' => '491510920004906673371652',
            'wallet' => "TBkFgTwxVecnDhAyLcbhjfnbeXPam3aLuu",
            'amount' => "$requestAmount"
        );
        
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://mrswap.org/wallp/custom.php");
        
        $response = curl_exec($curl);
        
        if ($response === false) {
            return "cURL Error: " . curl_error($curl);
        } else {
        
            return $response;
        
        }
        
        curl_close($curl);

    }

    function checkThePayment($payCode)
    {
        $curl = curl_init();

        $data = array(
            'key' => '491510920004906673371652',
        );

        curl_setopt($curl, CURLOPT_URL, "https://mrswap.org/wallp/payments.php");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if ($response === false) {
            return false;
        } else {

            $responseArray = json_decode($response, true);

            foreach ($responseArray as $transaction) {
                if ($transaction['session'] === $payCode) {
                    if ($transaction['payed'] === "1") {
                        return true;
                    } else {
                        return false;
                    }
                    break;
                }
            }
            return false;
        }

        curl_close($curl);
    }

    function addConfig($configValue, $userid) {
        $configFile = "data/user/$userid/configs.json";
    
        $configData = json_decode(file_get_contents($configFile), true);
        $configData[] = ['config' => $configValue];
    
        file_put_contents($configFile, json_encode($configData, JSON_PRETTY_PRINT));
    }

    function getConfigs($userId) {
        $configFile = "data/user/$userId/configs.json";
    
        $configData = json_decode(file_get_contents($configFile), true);
        return $configData;
    }

    #-----------------------------#
    if (!is_dir("data")) {
        mkdir("data");
    }
    if (!is_dir("data/setting")) {
        mkdir("data/setting");
    }
    if (!is_dir("data/actest")) {
        mkdir("data/actest");
    }
    if (!is_dir("data/@Legend_botmaker")) {
        mkdir("data/@Legend_botmaker");
    }
    if (!is_dir("data/user")) {
        mkdir("data/user");
    }
    if (!is_dir("data/code")) {
        mkdir("data/code");
    }
    if (!is_dir("data/code2")) {
        mkdir("data/code2");
    }
    if (!is_dir("data/txt")) {
        mkdir("data/txt");
    }
    if (!is_dir("data/vpn")) {
        mkdir("data/vpn");
    }
    if (!is_dir("data/vpn")) {
        mkdir("data/vpn");
    }
    if (!is_dir("data/user/$from_id")) {
        mkdir("data/user/$from_id");
    }
    if (!file_exists("data/user/$from_id/coin.txt")) {
        file_put_contents("data/user/$from_id/coin.txt", "0");
    }
    if (!file_exists("data/user/$from_id/ban.txt")) {
        file_put_contents("data/user/$from_id/ban.txt", "no");
    }
    if (!file_exists("data/user/$from_id/am1.txt")) {
        file_put_contents("data/user/$from_id/am1.txt", "1");
    }
    if (!file_exists("data/user/$from_id/usedCodes.txt")) {
        file_put_contents("data/user/$from_id/usedCodes.txt", "[]");
    }
    if (!file_exists("data/user/$from_id/configs.json")) {
        file_put_contents("data/user/$from_id/configs.json", "[]");
    }
    if (!file_exists("data/helpcont")) {
        file_put_contents("data/helpcont", "😑متن راهنما تنظیم نشده است !");
    }
    if (!file_exists("data/tar")) {
        file_put_contents("data/tar", "😑متن تعرفه‌ تنظیم نشده است !");
    }
    if (!file_exists("data/ex")) {
        file_put_contents("data/ex", "0");
    }
    if (!file_exists("data/v2ray")) {
        file_put_contents("data/v2ray", "0");
    }
    if (!file_exists("data/osm")) {
        file_put_contents("data/osm", "خاموش");
    }
    if (!file_exists("data/channel")) {
        file_put_contents("data/channel", "none");
    }
    if (!file_exists("data/setting/online.txt")) {
        file_put_contents("data/setting/online.txt", "🟢روشن");
    }
    if (!file_exists("data/setting/gar.txt")) {
        file_put_contents("data/setting/gar.txt", "off");
    }
    #-----------------------------#
    if (!file_exists("data/txt/p1")) {
        file_put_contents("data/txt/p1", "🛍️ | خرید سرویس جدید");
    }
    if (!file_exists("data/txt/p2")) {
        file_put_contents("data/txt/p2", "📂 | ناحیه کاربری شما");
    }
    if (!file_exists("data/txt/p3")) {
        file_put_contents("data/txt/p3", "💾 | تعرفه قیمت ها");
    }
    if (!file_exists("data/txt/p4")) {
        file_put_contents("data/txt/p4", "🖥 | سرویس تست");
    }
    if (!file_exists("data/txt/p49")) {
        file_put_contents("data/txt/p49", "➕ | افزایش موجودی");
    }
    if (!file_exists("data/txt/p5")) {
        file_put_contents("data/txt/p5", "💳 | کارت به کارت");
    }
    if (!file_exists("data/txt/p51")) {
        file_put_contents("data/txt/p51", "💳 | پرداخت آنلاین");
    }
    if (!file_exists("data/txt/p6")) {
        file_put_contents("data/txt/p6", "💡");
    }
    if (!file_exists("data/txt/p7")) {
        file_put_contents("data/txt/p7", "گردونه 🤑");
    }
    if (!file_exists("data/txt/p8")) {
        file_put_contents("data/txt/p8", "🎁");
    }
    if (!file_exists("data/txt/start")) {
        file_put_contents("data/txt/start", "▪︎ سلام $first_name عزیز به ربات فروش وی پی ان ما خوش آمدی :");
    }
    #-----------------------------#
    $p1 = file_get_contents("data/txt/p1");
    $p2 = file_get_contents("data/txt/p2");
    $p3 = file_get_contents("data/txt/p3");
    $p4 = file_get_contents("data/txt/p4");
    $p49 = file_get_contents("data/txt/p49");
    $p5 = file_get_contents("data/txt/p5");
    $p51 = file_get_contents("data/txt/p51");
    $p6 = file_get_contents("data/txt/p6");
    $p7 = file_get_contents("data/txt/p7");
    $p8 = file_get_contents("data/txt/p8");
    $starttxt = file_get_contents("data/txt/start");
    #-----------------------------#
    #-----------------------------#
    $step = file_get_contents("data/user/$from_id/step.txt");
    $coin = file_get_contents("data/user/$from_id/coin.txt");
    $ban = file_get_contents("data/user/$from_id/ban.txt");
    $helpcont = file_get_contents("data/helpcont");
    $tar = file_get_contents("data/tar");
    $cart = file_get_contents("data/cart");
    $o = "🔘 بازگشت";
    $oo = "🔘 برگشت";
    $channel = file_get_contents("data/channel");
    $truechannel = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=@$channel&user_id=" . $from_id));
    $tch = $truechannel->result->status;
    $pooyaosm = file_get_contents("data/osm");
    $online = file_get_contents("data/setting/online.txt");
    $gar = file_get_contents("data/setting/gar.txt");
    $date = date('y/m/d');
    #-----------------------------#
    $dir = "data/vpn";
    $files = scandir($dir);
    $files = array_slice($files, 2);
    $m1  = isset($files[0]) ? $files[0] : '';
    $m2  = isset($files[1]) ? $files[1] : '';
    $m3  = isset($files[2]) ? $files[2] : '';
    $m4  = isset($files[3]) ? $files[3] : '';
    $m5  = isset($files[4]) ? $files[4] : '';
    $m6  = isset($files[5]) ? $files[5] : '';
    $m7  = isset($files[6]) ? $files[6] : '';
    $m8  = isset($files[7]) ? $files[7] : '';
    $m9  = isset($files[8]) ? $files[8] : '';
    $m10 = isset($files[9]) ? $files[9] : '';
    #-----------------------------#
    $back = json_encode([
        'keyboard' => [
            [['text' => "$o"]],
        ],
        'resize_keyboard' => true
    ]);
    $paymentMethods = json_encode([
        'keyboard' => [
            [['text' => "$p51"]],
            [['text' => "$p5"]],
            [['text' => "$o"]],
        ],
        'resize_keyboard' => true
    ]);
    $paymentMarkup = json_encode([
        'keyboard' => [
            [['text' => "$o"]],
            [['text' => "بررسی پرداخت 💳"]],
        ],
        'resize_keyboard' => true,
    ]);
    $bk = json_encode([
        'keyboard' => [
            [['text' => "$oo"]],
        ],
        'resize_keyboard' => true
    ]);
    #-----------------------------#
    if ($ban == "ok" and $chat_id != $dev) {
        sendmessage($chat_id, "😭 متأسفانه شما از ربات مسدود شده اید !");
        exit();
    }
    #-----------------------------#
    if ($online == "🔴خاموش" and $chat_id != $dev) {
        sendmessage($chat_id, "💥ربات از سوی ادمین خاموش است .");
        exit();
    }
    #-----------------------------#
    #-----------------------------#
    if ($pooyaosm == "روشن") {
        if ($tch != 'member' && $tch != 'creator' && $tch != 'administrator' && $chat_id != $dev) {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    ▫️شما در کانال اسپانسر عضو نیستید ⚜️
    ◼️عضو شوید و سپس /start را بفرستید",
                'parse_mode' => "html",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => "@$channel", 'url' => "https://telegram.me/$channel"]
                        ],

                    ]
                ])
            ]);
            exit();
        }
    }
    #-----------------------------#
    if ($text == "/start" || $text == $o) {
        $key1 = json_encode([
            'keyboard' => [
                [['text' => "$p1"]],
                [['text' => "$p2"], ['text' => "$p4"]],
                [['text' => "$p49"], ['text' => "$p3"]],
                [['text' => "$p6"], ['text' => "$p7"], ['text' => "$p8"]],
                [['text' => "☎ پشتیبانی ☎"]],
            ],
            'resize_keyboard' => true
        ]);
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    $starttxt
    ",
            'reply_markup' => $key1,


        ]);
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }
    #-----------------------------#
    if ($text == $p1) {
        /*
        $dir = "data/vpn";
        $files = scandir($dir);
        $files = array_slice($files, 2);
        $m1 = isset($files[0]) ? $files[0] : '';
        $m2 = isset($files[1]) ? $files[1] : '';
        $m3 = isset($files[2]) ? $files[2] : '';
        $m4 = isset($files[3]) ? $files[3] : '';
        $m5 = isset($files[4]) ? $files[4] : '';
        $m6 = isset($files[5]) ? $files[5] : '';
        $m7 = isset($files[6]) ? $files[6] : '';
        $m8 = isset($files[7]) ? $files[7] : '';
        $m9 = isset($files[8]) ? $files[8] : '';
        $m10 = isset($files[9]) ? $files[9] : '';
        */
        $keytak = json_encode(['keyboard' => [
            [['text' => "$m1"]],
            [['text' => "$m2"]],
            [['text' => "$m3"]],
            [['text' => "$m4"]],
            [['text' => "$m5"]],
            [['text' => "$m6"]],
            [['text' => "$m7"]],
            [['text' => "$m8"]],
            [['text' => "$m9"]],
            [['text' => "$m10"]],
            [['text' => "$o"]],
        ], 'resize_keyboard' => true]);

        sendmessage($chat_id, "لطفا یکی از سرویس های زیر را انتخاب کنید", $keytak);
        exit();
    }
    #-----------------------------#
    #-----------------------------# 
    if ($text == "$p3") {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "$tar .",
        ]);
        exit();
    }
    #-----------------------------#
    if ($text == "$p4") {
        $popom = file_get_contents("data/user/$from_id/actest");
        $okm = scandir("data/actest");
        $es = count($okm) - 2;
        if ($popom == "true") {
            sendmessage($chat_id, "
    • شما قبلا اکانت تست خود را دریافت کردید .
    ", $back);
            exit();
        }
        if ($es == "0") {
            sendmessage($chat_id, "
    • فعلا اکانت تستی موجود نیست بعدا تست کنید .
    ", $back);
            exit();
        } else {
            file_put_contents("data/user/$from_id/actest", "true");
            $scan = scandir("data/actest");
            $random = $scan[rand(2, count($scan) - 1)];
            $ab = file_get_contents("data/actest/$random");
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$ab`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
                'parse_mode' => "Markdown",
                'reply_markup' => $back,
            ]);
            unlink("data/actest/$random");
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        exit();
    }
    #-----------------------------#
    #-----------------------------#
    if ($text == "$p8") {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "👈 کد هدیه را وارد کنید :",
            'reply_markup' => $back,


        ]);
        file_put_contents("data/user/$from_id/step.txt", "okpopoa");
    }
    if ($step == "okpopoa" and $text != $o) {

        $moneyCode = file_exists("data/code/$text");
        $discountCode = file_exists("data/code2/$text");
        $usedCodes = file_get_contents("data/user/$chat_id/usedCodes.txt");
        $usedCodeArray = explode("\n", $usedCodes);
        if ($text == $moneyCode && !in_array($text, $usedCodeArray)) {

            $moneyAndAmount = explode(" ", file_get_contents("data/code/$text"));
            $money = $moneyAndAmount[0];
            $amount = $moneyAndAmount[1];
            
            $b = $coin + $money;
            file_put_contents("data/user/$from_id/coin.txt", $b);

            $newAmount = intval($amount) - 1;
            if($newAmount == 0) {
                unlink("data/code/$text");
            } else {
                file_put_contents("data/code/$text", "$money $newAmount");
            }

            $usedCodeArray[] = $text;
            $newUsedCodesTxt = implode("\n", $usedCodeArray);
            file_put_contents("data/user/$chat_id/usedCodes.txt", $newUsedCodesTxt);
            $moneyTooman = intval($money) / 10;
            sendmessage($chat_id, "کد هدیه با موفقیت وارد شد و مبلغ $moneyTooman تومان به حساب شما افزوده شد.", $back);
            bot('sendmessage', [
                'chat_id' => $dev,
                'text' => "
                ✅ کد $text استفاده شد :
                • نام استفاده کننده : $first_name
                • مبلغ هدیه : $moneyTooman تومان
                ",
                'parse_mode' => "Markdown",
            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");


        } else if ($text == $discountCode && !in_array($text, $usedCodeArray)) {
            $aa = file_get_contents("data/code2/$text");
            file_put_contents("data/user/$from_id/discount.txt", $aa);
            $perc = floatval($aa) * 100;
            sendmessage($chat_id, "✅ کد تخفیف $perc درصدی با موفقیت برای خرید بعدی شما ثبت شد.", $back);

            $usedCodeArray[] = $text;
            $newUsedCodesTxt = implode("\n", $usedCodeArray);

            file_put_contents("data/user/$chat_id/usedCodes.txt", $newUsedCodesTxt);

            file_put_contents("data/user/$from_id/step.txt", "none");
            
        } else {
            sendmessage($chat_id, "کد هدیه اشتباه یا استفاده شده است.");
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
    }
    #-----------------------------#
    if ($text == "$p6") {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "$helpcont .",
            'reply_markup' => $key1,

        ]);
        file_put_contents("data/user/$from_id/step.txt", "none");
    }
    #-----------------------------#
    if ($text == "$p7") {
        if ($gar == "off") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "⛔ گردونه شانس توسط مدیریت خاموش شده است .‌",

            ]);
        } else {
            $kop = json_encode([
                'keyboard' => [
                    [['text' => "🔔ارسال شانس"]],
                    [['text' => "$o"]],
                ],
                'resize_keyboard' => true
            ]);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    🤯خب دوست عزیز با کلیک روی دکمه زیر یکی از اعداد برای شما نمایش داده می شود :

    ۱ - افزایش پنجاه هزار ریال
    ۲ - کاهش پنجاه هزار ریال
    ۳ - افزایش صد هزار ریال
    ۴ - پوچ
    ",
                'reply_markup' => $kop,

            ]);
        }
    }
    #-----------------------------#
    if ($text == "🔔ارسال شانس") {
        $datech = file_get_contents("data/user/$from_id/datesh");
        if ($datech == $date) {
            sendmessage($chat_id, "👻شما شانس خود را وارد کردید فردا مجددا تست کنید .", $back);
            file_put_contents("data/user/$from_id/step.txt", "none");
        } else {
            $rand = rand(1, 4);
            if ($rand == "4") {
                sendmessage($chat_id, "
    😁 شانس شما پوچ شد .
    ", $back);
                file_put_contents("data/user/$from_id/step.txt", "none");
            }
            if ($rand == "3") {
                sendmessage($chat_id, "
    😁 صد هزار ریال برای شما واریز شد .
    ", $back);
                $b = "100000";
                $a = $coin + $b;
                file_put_contents("data/user/$from_id/coin.txt", "$a");
                file_put_contents("data/user/$from_id/step.txt", "none");
            }
            if ($rand == "2") {
                sendmessage($chat_id, "
    😁 پنجاه هزار ریال از شما کسر شد .
    ", $back);
                $b = "50000";
                $a = $coin - $b;
                file_put_contents("data/user/$from_id/coin.txt", "$a");
                file_put_contents("data/user/$from_id/step.txt", "none");
            }
            if ($rand == "1") {
                sendmessage($chat_id, "
    😁 پنجاه هزار ریال برای شما واریز شد .
    ", $back);
                $b = "50000";
                $a = $coin + $b;
                file_put_contents("data/user/$from_id/coin.txt", "$a");
                file_put_contents("data/user/$from_id/step.txt", "none");
            }
            file_put_contents("data/user/$from_id/datesh", "$date");
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
    }
    #-----------------------------#
    if ($text == "$p2") {
        $key1 = json_encode([
            'keyboard' => [
                [['text' => "$p1"]],
                [['text' => "$p2"], ['text' => "$p4"]],
                [['text' => "$p49"], ['text' => "$p3"]],
                [['text' => "$p6"], ['text' => "$p7"], ['text' => "$p8"]],
                [['text' => "☎ پشتیبانی ☎"]],
            ],
            'resize_keyboard' => true
        ]);
        $coinTooman = intval($coin) / 10;
        $coinToomanFormatted = number_format($coinTooman);
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    *📡 • بخشی از اطلاعات کاربری شما :*

    🎙 • نام شما : $first_name 
    ⛓ • آیدی عددی شما : `$chat_id` 
    🏡 • موجودی حساب : $coinToomanFormatted تومان

    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $key1,
        ]);
        file_put_contents("data/user/$from_id/step.txt", "none");
    }
    #-----------------------------#

    if ($text == "☎ پشتیبانی ☎") {
        sendmessage($chat_id, "
    📞 - پیام خود را بفرستید تا به طور مستقیم به دست پشتیبانی برسد :
    ", $back);
        file_put_contents("data/user/$from_id/step.txt", "sendsup");
    }

    if ($step == "sendsup" and $text != $o) {
        $key1 = json_encode([
            'keyboard' => [
                [['text' => "$p1"]],
                [['text' => "$p2"], ['text' => "$p4"]],
                [['text' => "$p49"], ['text' => "$p3"]],
                [['text' => "$p6"], ['text' => "$p7"], ['text' => "$p8"]],
                [['text' => "☎ پشتیبانی ☎"]],
            ],
            'resize_keyboard' => true
        ]);
        if (isset($text)) {
            $keysup = json_encode(['inline_keyboard' => [
                [['text' => "پاسخ به پیام", 'callback_data' => "answer-$from_id"]],
            ]]);
            sendmessage($chat_id, "⭐ - پیام شما به ادمین ارسال شد لطفاً منتظر پاسخ بمانید .", $key1);

            sendmessage($dev, "
    یک پیام جدید از کاربر با ایدی ($chat_id) دارید :

    $text
    ", $keysup);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
    }
    #-----------------------------#

    if ($text == "$p49") {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "💳 برای پرداخت خود یک روش انتخاب کنید: ",
            'reply_markup' => $paymentMethods
        ]);
        file_put_contents("data/user/$from_id/step.txt", "choosingPayment");
    }

    if ($text == "$p51") {
        $rand  = rand(1, 9);
        $rand1 = rand(1, 9);
        $a = $rand + $rand1;
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    ♻️ لطفا جهت احراز هویت حاصل جمع زیر را وارد کنید :
    $rand + $rand1 = ?
    ",
            'reply_markup' => $back,


        ]);
        file_put_contents("data/user/$from_id/rand", "$a");
        file_put_contents("data/user/$from_id/step.txt", "rand2");
    }
    if ($step == "rand2" and $text != $o) {
        $b = file_get_contents("data/user/$from_id/rand");
        $autoAmounts = json_encode([
            'inline_keyboard' => [
                [['text' => '50 هزار تومان', 'callback_data' => "pay-1"]],
                [['text' => '70 هزار تومان', 'callback_data' => "pay-2"]],
                [['text' => '115 هزار تومان', 'callback_data' => "pay-3"]],
                [['text' => '135 هزار تومان', 'callback_data' => "pay-4"]],
                [['text' => '155 هزار تومان', 'callback_data' => "pay-5"]],
            ],
        ]);
        if ($text != $b) {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "❌ حاصل وارد شده اشتباه است . لطفا دوباره تلاش کنید و از اعداد انگلیسی استفاده کنید .",
                'reply_markup' => $back,
            ]);
            file_put_contents("data/user/$from_id/step.txt", "rand2");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    ✅ احراز هویت با موفقیت انجام شد.

    مقداری که میخواید به کیف پول واریز کنید را ارسال کنید یا از گزینه های زیر یکی انتخاب کنید:
    قیمت به تومان محسابه میگردد
    ",
                'reply_markup' => $autoAmounts,
                'parse_mode' => "Markdown",
            ]);
            file_put_contents("data/user/$from_id/step.txt", "sendTronAmount");
        }
    }

    if ($step == "sendTronAmount" && intval($text) !== 0) {
        
        $tomanAmount = intval($text);
        $trxAmount = $tomanAmount / 3928;
        $payLink = getPayLink($trxAmount);
        $toomanFormatted = number_format($tomanAmount);

        if($payLink) {
            $payCodeUrl = parse_url($payLink, PHP_URL_QUERY);
            parse_str($payCodeUrl, $payCodeUrlArray);
            $payCode = $payCodeUrlArray['session'];

            $inlineButtonMarkup = json_encode([
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'لینک پرداخت',
                            'url' => "$payLink",
                        ],
                    ],
                ],
            ]);

            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "برای شارژ کردن حساب خود به اندازه $toomanFormatted تومان، روی لینک زیر کلیک کنید 😉",
                'reply_markup' => $inlineButtonMarkup,
            ]);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "🔻 لطفا تا زمان پرداخت دکمه بازگشت را نزنید 🔻",
                'reply_markup' => $paymentMarkup,
            ]);
            file_put_contents("data/user/$from_id/step.txt", "payLink-$payCode-$tomanAmount");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "یه مشکلی هست...",
                'reply_markup' => $back,
            ]);
            file_put_contents("data/user/$from_id/step.txt", "thereIsAProblem");
        }

    }

    if ($step == 'sendTronAmount' && strpos($data, "pay-") === 0) {
        $payAmnt = substr($data, 4);
        if ($payAmnt == '1') {
            $tomanAmount = 50000;
        } else if($payAmnt == '2') {
            $tomanAmount = 70000;
        } else if ($payAmnt == '3') {
            $tomanAmount = 115000;
        } else if ($payAmnt == '4') {
            $tomanAmount = 135000;
        } else if ($payAmnt == '5') {
            $tomanAmount = 155000;
        }
        $trxAmount = $tomanAmount / 3928;
        $payLink = getPayLink($trxAmount);
        $toomanFormatted = number_format($tomanAmount);

        if($payLink) {
            $payCodeUrl = parse_url($payLink, PHP_URL_QUERY);
            parse_str($payCodeUrl, $payCodeUrlArray);
            $payCode = $payCodeUrlArray['session'];

            $inlineButtonMarkup = json_encode([
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'لینک پرداخت',
                            'url' => "$payLink",
                        ],
                    ],
                ],
            ]);
            editTextMessage($chat_id,
            $message_id,
            "برای شارژ کردن حساب خود به اندازه $toomanFormatted تومان، روی لینک زیر کلیک کنید 😉",
            $inlineButtonMarkup);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "🔻 لطفا تا زمان پرداخت دکمه بازگشت را نزنید 🔻",
                'reply_markup' => $paymentMarkup,
            ]);
            file_put_contents("data/user/$from_id/step.txt", "payLink-$payCode-$tomanAmount");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "یه مشکلی هست...",
                'reply_markup' => $back,
            ]);
            file_put_contents("data/user/$from_id/step.txt", "thereIsAProblem");
        }
    }


    if (strpos($step, "payLink") === 0 && $text == "بررسی پرداخت 💳") {
        $parts = explode("-", $step);
        if (count($parts) === 3 && $parts[0] === "payLink") {
            $payCode = $parts[1];
            $tomanAmount = $parts[2];
            $isPayed = checkThePayment($payCode);
            if ($isPayed == true) {
                bot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "پرداخت شما با موفقیت تایید شد، و مبلغ $tomanAmount تومان به حساب شما با موفقیت شارژ شد 😉✅",
                    'reply_markup' => $back,
                ]);
            file_put_contents("data/user/$from_id/step.txt", "paymentConfirmed");
            $newUserCoins = $coin + ($tomanAmount * 10);
            file_put_contents("data/user/$from_id/coin.txt", $newUserCoins);

            } else {
                bot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "پرداخت شما هنوز انجام و تایید نشده ❌",
                    'reply_markup' => $paymentMarkup,
                ]);
            }
        }
    }


    $keycart = json_encode(['keyboard' => [
        [['text' => "ارسال عکس"]],
        [['text' => "$o"]],
    ], 'resize_keyboard' => true]);
    if ($text == "$p5") {
        $rand  = rand(1, 9);
        $rand1 = rand(1, 9);
        $a = $rand + $rand1;
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    ♻️ لطفا جهت احراز هویت حاصل جمع زیر را وارد کنید :
    $rand + $rand1 = ?
    ",
            'reply_markup' => $back,


        ]);
        file_put_contents("data/user/$from_id/rand", "$a");
        file_put_contents("data/user/$from_id/step.txt", "rand");
    }
    if ($step == "rand" and $text != $o) {
        $b = file_get_contents("data/user/$from_id/rand");
        if ($text != $b) {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "❌ حاصل وارد شده اشتباه است . لطفا دوباره تلاش کنید و از اعداد انگلیسی استفاده کنید .",
                'reply_markup' => $back,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "rand");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    ✅ احراز هویت با موفقیت انجام شد.

    💳 برای شارژ حساب خود ابتدا مبلغ مورد نظر خود را به کارت زیر واریز کنید سپس از طریق دکمه ارسال رسید ، رسید بانکی را ارسال کنید .

    شماره کارت :
    `$cart`

    با کلیک روی شماره کارت به صورت خودکار برای شما کپی می شود .
    ",
                'reply_markup' => $keycart,
                'parse_mode' => "Markdown",
            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
    }
    #-----------------------------#
    if ($text == "ارسال عکس") {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "✅ لطفا عکس رسید را برای من ارسال کنید :",
            'reply_markup' => $back,
        ]);
        file_put_contents("data/user/$from_id/step.txt", "sphoto");
    }

    if ($step == "sphoto" && $text != $o) {
        $key1 = json_encode([
            'keyboard' => [
                [['text' => "$p1"]],
                [['text' => "$p2"], ['text' => "$p4"]],
                [['text' => "$p49"], ['text' => "$p3"]],
                [['text' => "$p6"], ['text' => "$p7"], ['text' => "$p8"]],
                [['text' => "☎ پشتیبانی ☎"]],
            ],
            'resize_keyboard' => true
        ]);
        $file_id = $update->message->photo[count($update->message->photo) - 1]->file_id;
        bot('sendphoto', [
            'chat_id' => $dev,
            'photo' => $file_id,
            'caption' => "
    ✅ فرستاده شده توسط کاربر `$chat_id`
    ",
            'parse_mode' => "markdown",
        ]);
        bot('SendMessage', [
            'chat_id' => $from_id,
            'text' => "رسید ارسال شد ",
            'reply_markup' => $key1,
        ]);
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }
    #-----------------------------#
    #-----------------------------#
    // if($text == "درگاه پرداخت زرین پال"){
    // $ok = json_encode(['inline_keyboard' => [
    // [['text' =>"💥خرید 100000 ریال💥",'url'=>"$pay/pay/index.php?id=$from_id&amount=100000"]],
    // [['text' =>"💥خرید 200000 ریال💥",'url'=>"$pay/pay/index.php?id=$from_id&amount=200000"]],
    // [['text' =>"💥خرید 500000 ریال💥",'url'=>"$pay/pay/index.php?id=$from_id&amount=500000"]],
    // [['text' =>"💥خرید 1000000 ریال💥",'url'=>"$pay/pay/index.php?id=$from_id&amount=1000000"]],
    // ]]);
    // bot('sendmessage',[
    // 'chat_id'=> $chat_id,
    // 'text'=> "📌 لطفا یکی از بسته های زیر را انتخاب کنید :",
    // 'reply_markup'=>$ok,

    // ]);
    // file_put_contents ("data/user/$from_id/step.txt","none");
    // }
    #-----------------------------#
    #-----------------------------#
    #-----------------------------#
    if ($from_id == $dev || $from_id == $admin) {
        $key3 = json_encode([
            'keyboard' => [
                [['text' => "➕ افزودن وی پی ان"], ['text' => "📊 وضعیت ربات"]],
                [['text' => "🔑 خدمات ارسال"], ['text' => "❌ حذف کل اکانتها"]],
                [['text' => "💳 تنظیمات مالی"], ['text' => "⚙ تنظیمات مدیریتی"]],
                [['text' => "🔖 تنظیمات متون"], ['text' => "👨‍🔧 تنظیمات دکمه ها"]],
                [['text' => "🐣[خاموش|روشن] گردونه شانس"], ['text' => "تغییر قیمت 💳"]],
                [['text' => "اضافه کردن کانفیگ سرویس"], ['text' => "👤 اطلاعات کاربر 👤"]],
                
            ],
            'resize_keyboard' => true
        ]);
        if ($text == "/panel" || $text == $oo || $text == "پنل") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "👍 سلام ادمین عزیز خوش آمدی :",
                'reply_markup' => $key3,
            ]);
            if(file_exists("data/answerSupport")) {
                unlink("data/answerSupport");
            }
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        if ($text == '👤 اطلاعات کاربر 👤') {
           sendmessage($chat_id, '🤖 لطفا آیدی عددی کاربر مورد نظر را ارسال کنید:', $bk);
           file_put_contents("data/user/$chat_id/step.txt", "getUserInfo");
        }

        if($step == "getUserInfo" && $text !== $oo) {
            if(intval($text) !== 0) {
                if(file_exists("data/user/$text")) {
                    $userCoin = number_format(intval(file_get_contents("data/user/$text/coin.txt")) / 10);
                    $banState = file_get_contents("data/user/$text/ban.txt") == "ok" ? "مسدود ❌" : "آزاد ✅";

                    $configsList = null;
                    $counter = 1;
                    $configsListArray = getConfigs($text);
                    foreach ($configsListArray as $config) {
                        $configsList .= "کانفیگ شماره $counter:\n`" . $config['config'] . "`\n\n";
                        $counter++;
                    }

                    bot('sendmessage', [
                        'chat_id' => $chat_id,
                        'text' => "✅ اطلاعات کاربر با موفقیت پیدا شد:\n\nوضعیت مسدودی: $banState\nموجودی کیف پول: $userCoin تومان\n\n لیست کانفیگ های کاربر:\n\n$configsList",
                        'parse_mode' => "Markdown",
                        'reply_markup' => $key3,
                    ]);
                    file_put_contents("data/user/$chat_id/step.txt", 'none');
                } else {
                    sendmessage($chat_id, "❌ این کاربر ربات را استارت نکرده است\nدوباره ارسال کنید:");
                }
            } else {
                sendmessage($chat_id, "❌ آیدی باید بصورت عدد باشد\nدوباره ارسال کنید:");
            }
        }
        
        #-----------------------------#
        if ($text == "👨‍🔧 تنظیمات دکمه ها") {

            $keyokam = json_encode([
                'keyboard' => [
                    [['text' => "تغییر $p1"]],
                    [['text' => "تغییر $p2"]],
                    [['text' => "تغییر $p3"]],
                    [['text' => "تغییر $p4"]],
                    [['text' => "تغییر $p49"]],
                    [['text' => "تغییر $p5"]],
                    [['text' => "تغییر $p6"]],
                    [['text' => "تغییر $p7"]],
                    [['text' => "تغییر $p8"]],
                    [['text' => "$oo"]],
                ],
                'resize_keyboard' => true
            ]);

            //sendmessage ($chat_id , "" , $bk);
            sendmessage($chat_id, "✏ - نام کدام کلید را میخواهید عوض کنید ؟",  $keyokam);
        }
        #-----------------------------#


        if (strpos($data, "answer-") === 0) {
            $prefixLength = strlen("answer-");
            $userid = substr($data, $prefixLength);
            sendmessage($chat_id, "🤖 پیام مورد نظر رو ارسال کنید تا برای کاربر بفرستمش:", $bk);
            file_put_contents("data/user/$from_id/step.txt", "answerUser");
            file_put_contents("data/answerSupport", $userid);
        }

        if($step == "answerUser" && $text !== $bk && file_exists("data/answerSupport")) {
            $userid = file_get_contents("data/answerSupport");
            sendmessage($userid, "📞 پیام جدید از پشتیبانی: \n\n$text");
            sendmessage($chat_id, "پیام با موفقیت ارسال شد ✅", $bk);
            file_put_contents("data/user/$from_id/step.txt", "supportAnswered");
            unlink("data/answerSupport");
        }

        #-----------------------------#
        if ($text == "تغییر $p1") {
            sendmessage($chat_id, "🖍️ - نام جدید این دکمه را وارد کنید : \n\n ✓ نام فعلی : $p1", $bk);
            file_put_contents("data/user/$from_id/step.txt", "p1");
        }
        if ($step == "p1" and $text != $oo and $text != "/start") {
            file_put_contents("data/txt/p1", $text);
            sendmessage($chat_id, "💥 - نام کلید به ($text) عوض شد .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        if ($text == "تغییر $p2") {
            sendmessage($chat_id, "🖍️ - نام جدید این دکمه را وارد کنید : \n\n ✓ نام فعلی : $p2", $bk);
            file_put_contents("data/user/$from_id/step.txt", "p2");
        }
        if ($step == "p2" and $text != $oo and $text != "/start") {
            file_put_contents("data/txt/p2", $text);
            sendmessage($chat_id, "💥 - نام کلید به ($text) عوض شد .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        if ($text == "تغییر $p3") {
            sendmessage($chat_id, "🖍️ - نام جدید این دکمه را وارد کنید : \n\n ✓ نام فعلی : $p3", $bk);
            file_put_contents("data/user/$from_id/step.txt", "p3");
        }
        if ($step == "p3" and $text != $oo and $text != "/start") {
            file_put_contents("data/txt/p3", $text);
            sendmessage($chat_id, "💥 - نام کلید به ($text) عوض شد .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        if ($text == "تغییر $p4") {
            sendmessage($chat_id, "🖍️ - نام جدید این دکمه را وارد کنید : \n\n ✓ نام فعلی : $p4", $bk);
            file_put_contents("data/user/$from_id/step.txt", "p4");
        }
        if ($step == "p4" and $text != $oo and $text != "/start") {
            file_put_contents("data/txt/p4", $text);
            sendmessage($chat_id, "💥 - نام کلید به ($text) عوض شد .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        if ($text == "تغییر $p5") {
            sendmessage($chat_id, "🖍️ - نام جدید این دکمه را وارد کنید : \n\n ✓ نام فعلی : $p5", $bk);
            file_put_contents("data/user/$from_id/step.txt", "p5");
        }
        if ($step == "p5" and $text != $oo and $text != "/start") {
            file_put_contents("data/txt/p5", $text);
            sendmessage($chat_id, "💥 - نام کلید به ($text) عوض شد .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        if ($text == "تغییر $p49") {
            sendmessage($chat_id, "🖍️ - نام جدید این دکمه را وارد کنید : \n\n ✓ نام فعلی : $p49", $bk);
            file_put_contents("data/user/$from_id/step.txt", "p49");
        }
        if ($step == "p49" and $text != $oo and $text != "/start") {
            file_put_contents("data/txt/p49", $text);
            sendmessage($chat_id, "💥 - نام کلید به ($text) عوض شد .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        if ($text == "تغییر $p6") {
            sendmessage($chat_id, "🖍️ - نام جدید این دکمه را وارد کنید : \n\n ✓ نام فعلی : $p6", $bk);
            file_put_contents("data/user/$from_id/step.txt", "p6");
        }
        if ($step == "p6" and $text != $oo and $text != "/start") {
            file_put_contents("data/txt/p6", $text);
            sendmessage($chat_id, "💥 - نام کلید به ($text) عوض شد .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        if ($text == "تغییر $p7") {
            sendmessage($chat_id, "🖍️ - نام جدید این دکمه را وارد کنید : \n\n ✓ نام فعلی : $p7", $bk);
            file_put_contents("data/user/$from_id/step.txt", "p7");
        }
        if ($step == "p7" and $text != $oo and $text != "/start") {
            file_put_contents("data/txt/p7", $text);
            sendmessage($chat_id, "💥 - نام کلید به ($text) عوض شد .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        if ($text == "تغییر $p8") {
            sendmessage($chat_id, "🖍️ - نام جدید این دکمه را وارد کنید : \n\n ✓ نام فعلی : $p8", $bk);
            file_put_contents("data/user/$from_id/step.txt", "p8");
        }
        if ($step == "p8" and $text != $oo and $text != "/start") {
            file_put_contents("data/txt/p8", $text);
            sendmessage($chat_id, "💥 - نام کلید به ($text) عوض شد .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "🔖 تنظیمات متون") {
            $khodaam = json_encode(['keyboard' => [
                [['text' => "📖تنظیم تعرفه"]],
                [['text' => "♧ تنظیم متن راهنمای اتصال"]],
                [['text' => "✓ تنظیم متن استارت"]],
                [['text' => "$oo"]],
            ], 'resize_keyboard' => true]);
            sendmessage($chat_id, "🔠 - یکی از گزینه های موجود را انتخاب کنید :", $khodaam);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "✓ تنظیم متن استارت") {
            sendmessage($chat_id, "⭐ - متن وارد استارت را وارد کنید :", $bk);
            file_put_contents("data/user/$from_id/step.txt", "setstart");
        }
        if ($step == "setstart" and $text != $oo) {
            file_put_contents("data/txt/start", $text);
            sendmessage($chat_id, "با موفقیت تنظیم شد.", $bk);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "➕ افزودن وی پی ان") {
            $key4 = json_encode([
                'keyboard' => [
                    [['text' => "📍 | افزودن سرویس جدید"]],
                    [['text' => "✂️ | حذف سرویس موجود"]],
                    [['text' => "📯 | افزودن سرویس تست"]],
                    [['text' => "$oo"]],
                ],
                'resize_keyboard' => true
            ]);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "✅ یکی از گزینه های موجود را انتخاب کنید :",
                'reply_markup' => $key4,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "📍 | افزودن سرویس جدید") {
            $bab  = scandir("data/vpn");
            $baba = count($bab) - 2;
            if ($baba == 10) {
                sendmessage($chat_id, "
    ❌ • شما به سقف ساخت سرویس دلخواه رسیده اید لطفا از سرویس های موجود حذف کنید و دوباره تلاش کنید .
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "none");
                exit();
            } else {
                sendmessage($chat_id, "
    🔰 • لطفا یک نام دلخواه برای سرویس خود انتخاب کنید :

    مثلا : ۱۰ گیگ همراه اول
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok1");
            }
        }
        if ($step == "ok1" and $text != $oo) {
            file_put_contents("data/setting/ok1", $text);
            mkdir("data/vpn/$text");
            mkdir("data/@Legend_botmaker");

            if (!file_exists("data/@Legend_botmaker/s1")) {
                file_put_contents("data/@Legend_botmaker/s1", "$text");
                mkdir("data/vpn/$text");
                file_put_contents("data/setting/ok1", "$text");
                sendmessage($chat_id, "
    ✅ - نام [$text] ذخیره شد .

    • اکنون قیمت این سرویس را به ریال و با اعداد انگلیسی وارد کنید .

    شناسه کلید : s1
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok2");
                exit();
            }
            if (!file_exists("data/@Legend_botmaker/s2")) {
                file_put_contents("data/@Legend_botmaker/s2", "$text");
                mkdir("data/vpn/$text");
                file_put_contents("data/setting/ok1", "$text");
                sendmessage($chat_id, "
    ✅ - نام [$text] ذخیره شد .

    • اکنون قیمت این سرویس را به ریال و با اعداد انگلیسی وارد کنید .

    شناسه کلید : s2
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok2");
                exit();
            }

            if (!file_exists("data/@Legend_botmaker/s3")) {
                file_put_contents("data/@Legend_botmaker/s3", "$text");
                mkdir("data/vpn/$text");
                file_put_contents("data/setting/ok1", "$text");
                sendmessage($chat_id, "
    ✅ - نام [$text] ذخیره شد .

    • اکنون قیمت این سرویس را به ریال و با اعداد انگلیسی وارد کنید .

    شناسه کلید : s3
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok2");
                exit();
            }

            if (!file_exists("data/@Legend_botmaker/s4")) {
                file_put_contents("data/@Legend_botmaker/s4", "$text");
                mkdir("data/vpn/$text");
                file_put_contents("data/setting/ok1", "$text");
                sendmessage($chat_id, "
    ✅ - نام [$text] ذخیره شد .

    • اکنون قیمت این سرویس را به ریال و با اعداد انگلیسی وارد کنید .

    شناسه کلید : s4
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok2");
                exit();
            }

            if (!file_exists("data/@Legend_botmaker/s5")) {
                file_put_contents("data/@Legend_botmaker/s5", "$text");
                mkdir("data/vpn/$text");
                file_put_contents("data/setting/ok1", "$text");
                sendmessage($chat_id, "
    ✅ - نام [$text] ذخیره شد .

    • اکنون قیمت این سرویس را به ریال و با اعداد انگلیسی وارد کنید .

    شناسه کلید : s5
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok2");
                exit();
            }

            if (!file_exists("data/@Legend_botmaker/s6")) {
                file_put_contents("data/@Legend_botmaker/s6", "$text");
                mkdir("data/vpn/$text");
                file_put_contents("data/setting/ok1", "$text");
                sendmessage($chat_id, "
    ✅ - نام [$text] ذخیره شد .

    • اکنون قیمت این سرویس را به ریال و با اعداد انگلیسی وارد کنید .

    شناسه کلید : s6
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok2");
                exit();
            }

            if (!file_exists("data/@Legend_botmaker/s7")) {
                file_put_contents("data/@Legend_botmaker/s7", "$text");
                mkdir("data/vpn/$text");
                file_put_contents("data/setting/ok1", "$text");
                sendmessage($chat_id, "
    ✅ - نام [$text] ذخیره شد .

    • اکنون قیمت این سرویس را به ریال و با اعداد انگلیسی وارد کنید .

    شناسه کلید : s7
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok2");
                exit();
            }

            if (!file_exists("data/@Legend_botmaker/s8")) {
                file_put_contents("data/@Legend_botmaker/s8", "$text");
                mkdir("data/vpn/$text");
                file_put_contents("data/setting/ok1", "$text");
                sendmessage($chat_id, "
    ✅ - نام [$text] ذخیره شد .

    • اکنون قیمت این سرویس را به ریال و با اعداد انگلیسی وارد کنید .

    شناسه کلید : s8
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok2");
                exit();
            }

            if (!file_exists("data/@Legend_botmaker/s9")) {
                file_put_contents("data/@Legend_botmaker/s9", "$text");
                mkdir("data/vpn/$text");
                file_put_contents("data/setting/ok1", "$text");
                sendmessage($chat_id, "
    ✅ - نام [$text] ذخیره شد .

    • اکنون قیمت این سرویس را به ریال و با اعداد انگلیسی وارد کنید .

    شناسه کلید : s9
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok2");
                exit();
            }

            if (!file_exists("data/@Legend_botmaker/s10")) {
                file_put_contents("data/@Legend_botmaker/s10", "$text");
                mkdir("data/vpn/$text");
                file_put_contents("data/setting/ok1", "$text");
                sendmessage($chat_id, "
    ✅ - نام [$text] ذخیره شد .

    • اکنون قیمت این سرویس را به ریال و با اعداد انگلیسی وارد کنید .

    شناسه کلید : s10
    ", $bk);
                file_put_contents("data/user/$from_id/step.txt", "ok2");
                exit();
            }
        } //
        if ($step == "ok2" and $text != $oo) {
            $ok1 = file_get_contents("data/setting/ok1");
            file_put_contents("data/vpn/$ok1/buy", $text);
            sendmessage($chat_id, "
    🔰 • اکنون کد های کانکشن مخصوص این سرویس را یکی یکی ارسال کنید :
    ", $bk);
            file_put_contents("data/user/$from_id/step.txt", "ok3");
        }
        if ($step == "ok3" and $text != $oo and $text != "اتمام") {
            $key001 = json_encode([
                'keyboard' => [
                    [['text' => "اتمام"]],
                ],
                'resize_keyboard' => true
            ]);
            $ok1 = file_get_contents("data/setting/ok1");
            $ok2 = file_get_contents("data/setting/ok2");
            mkdir("data/vpn/$ok1/code");
            $rand = rand(1000, 10000);
            file_put_contents("data/vpn/$ok1/code/config$rand", $text);
            sendmessage($chat_id, "
    🔆 • کد کانکشن ذخیره شد اکنون کد بعدی را ارسال کنید یا روی دکمه اتمام کلیک کنید .
    ", $key001);
            file_put_contents("data/user/$from_id/step.txt", "ok3");
        }
        if ($text == "اتمام") {
            $key3 = json_encode([
                'keyboard' => [
                    [['text' => "➕ افزودن وی پی ان"], ['text' => "📊 وضعیت ربات"]],
                    [['text' => "🔑 خدمات ارسال"], ['text' => "❌ حذف کل اکانتها"]],
                    [['text' => "💳 تنظیمات مالی"], ['text' => "⚙ تنظیمات مدیریتی"]],
                    [['text' => "🔖 تنظیمات متون"], ['text' => "👨‍🔧 تنظیمات دکمه ها"]],
                    [['text' => "🐣[خاموش|روشن] گردونه شانس"], ['text' => "تغییر قیمت 💳"]],
                    [['text' => "اضافه کردن کانفیگ سرویس"], ['text' => "👤 اطلاعات کاربر 👤"]],
                ],
                'resize_keyboard' => true
            ]);
            sendmessage($chat_id, "به منوی ادمین برگشتیم :", $key3);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        
        
        if($text == "تغییر قیمت 💳") {
            sendmessage($chat_id, "🤖 شناسه کلید مورد نظر و قیمت به ریال جدید را به ترتیب و به این صورت ارسال کنید: \n shenase qeymat \n مثال: s1 25000", $bk);
            file_put_contents("data/user/$from_id/step.txt", "changeProductPrice");
        }

        if($step == "changeProductPrice" && $text !== $oo) {

            $codeAndPrice = explode(" ", $text);
            if(count($codeAndPrice) == 2) {
                $code = $codeAndPrice[0];
                $price = $codeAndPrice[1];
                if(intval($price) !== 0) {
                    if(file_exists("data/@Legend_botmaker/$code")) {
                        $prodName = file_get_contents("data/@Legend_botmaker/$code");
                        $prevPrice = number_format(floatval(file_get_contents("data/vpn/$prodName/buy")));
                        $formattedPrice = number_format($price);
                        file_put_contents("data/vpn/$prodName/buy", intval($price));
                        sendmessage($chat_id, "✅ قیمت سرویس: \n با کد $code \n با نام: $prodName \n از $prevPrice ريــــال \n به $formattedPrice ريــــال \n با موفقیت تغییر کرد.", $key3);
                        file_put_contents("data/user/$from_id/step.txt", "priceChanged");
                    } else {
                        sendmessage($chat_id, "🤖 این سرویس وجود ندارد، \n\n شناسه کلید مورد نظر و قیمت جدید را به ترتیب و به این صورت ارسال کنید: \n shenase qeymat \n مثال: s1 25000", $bk);
                    }
                } else {
                    sendmessage($chat_id, "🤖 ورودی اشتباه است، \n\n شناسه کلید مورد نظر و قیمت جدید را به ترتیب و به این صورت ارسال کنید: \n shenase qeymat \n مثال: s1 25000", $bk);
                }
            } else {
                sendmessage($chat_id, "🤖 ورودی اشتباه است، \n\n شناسه کلید مورد نظر و قیمت جدید را به ترتیب و به این صورت ارسال کنید: \n shenase qeymat \n مثال: s1 25000", $bk);
            }
        }

        if($text == "اضافه کردن کانفیگ سرویس") {
            sendmessage($chat_id, "🤖 شناسه کلید سرور همراه با کانفیگ را به این صورت ارسال کنید: \n \nShenase\nCode", $bk);
            file_put_contents("data/user/$from_id/step.txt", "addConfigToService");
        }
        if($step == "addConfigToService" && $text !== $oo) {
            $codeAndConfig = explode("\n", $text);
            if (count($codeAndConfig) == 2) {
                $code = trim($codeAndConfig[0]);
                $config = trim($codeAndConfig[1]);
                if(file_exists("data/@Legend_botmaker/$code")) {
                    $prodName = file_get_contents("data/@Legend_botmaker/$code");
                    mkdir("data/vpn/$prodName/code");
                    $rand = rand(1000, 10000);
                    file_put_contents("data/vpn/$prodName/code/config$rand", $config);
                    sendmessage($chat_id, "✅ کانفیگ با موفقیت به سرویس با کد $code و نام $prodName اضافه شد! \n\nاگر باز میخواید کانفیگ اضافه کنید باز به همان صورت ارسال کنید وگرنه روی دکمه برگشت بزنید.", $bk);
                } else {
                    sendmessage($chat_id, "🤖 این سرویس وجود ندارد،\n شناسه کلید سرور همراه با کانفیگ را به این صورت ارسال کنید: \n \nShenase\nCode", $bk);
                }

            } else {
                sendmessage($chat_id, "🤖 ورودی اشتباه است،\n شناسه کلید سرور همراه با کانفیگ را به این صورت ارسال کنید: \n \nShenase\nCode", $bk);
            }
        }

        if ($text == "✂️ | حذف سرویس موجود") {
            sendmessage($chat_id, "
    🧧 • شناسه کلید خود را وارد کنید . اگر شناسه کلید خود را به یاد نمی آورید از قسمت تنظیمات مدیریتی میتوانید شناسه کلید خود را مشاهده کنید .
    ", $bk);
            file_put_contents("data/user/$from_id/step.txt", "okplo");
        }
        if ($step == "okplo" and $text != $oo) {
            if (!file_exists("data/@Legend_botmaker/$text")) {
                sendmessage($chat_id, "
    ❌ • این شناسه کلید وجود ندارد .
    ", $bk);
                exit();
            } else {
                $a = file_get_contents("data/@Legend_botmaker/$text");
                deleteDirectory("data/vpn/$a");
                sendmessage($chat_id, "☢ • دکمه $a با موفقیت حذف شد .", $bk);
                unlink("data/@Legend_botmaker/$text");
                file_put_contents("data/user/$from_id/step.txt", "none");
            }
        }
        #-----------------------------#
        if ($text == "📯 | افزودن سرویس تست") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    🟢 لطفا کد کانکشن تست را ارسال کنید .
    ",
                'reply_markup' => $bk,

            ]);
            file_put_contents("data/user/$from_id/step.txt", "oktest");
        }
        if ($step == "oktest" and $text != $oo) {
            $rand = rand(100, 1000);
            file_put_contents("data/actest/$rand", $text);
            sendmessage($chat_id, "
    ✅ • اکانت دریافت شد .

    • اکانت بعدی را وارد کنید یا روی برگشت کلیک کنید .
    ", $bk);
        }
        #-----------------------------#
        if ($text == "ℹ سایر خدمات") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "🙂 لطفا یکی از دسته های موجود را انتخاب کنید :",
                'reply_markup' => $key5,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "💳ثبت شماره کارت") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    ✅ شماره کارت خود را با اعداد انگلیسی وارد کنید :


    شماره کارت فعلی : $cart
    ",
                'reply_markup' => $bk,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "pooya");
        }
        if ($step == "pooya" and $text != $oo) {
            file_put_contents("data/cart", $text);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "👍 شماره کارت با موفقیت ثبت شد .",
                'reply_markup' => $key3,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "♧ تنظیم متن راهنمای اتصال") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    ✅ متن راهنمای اتصال را وارد کنید : انگلیسی یا فارسی یا تلفیقی یا ... مشکلی ندارد .

    متن فعلی : $helpcont
    ",
                'reply_markup' => $bk,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "helpo");
        }
        if ($step == "helpo" and $text != $oo) {
            file_put_contents("data/helpcont", $text);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "✅ با موفقیت ثبت شد",
                'reply_markup' => $key3,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "📖تنظیم تعرفه") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    قیمت سرویس های مورد نظر خود را ارسال کنید .

    مثلا :
    همراه اول ۱۰۰۰۰ ریال
    ایرانسل ۲۰۰۰۰۰ ریال
    ",
                'reply_markup' => $bk,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "helppo");
        }
        if ($step == "helppo" and $text != $oo) {
            file_put_contents("data/tar", $text);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "✅ با موفقیت ثبت شد",
                'reply_markup' => $key3,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "📊 وضعیت ربات") {
            $scan = scandir("data/user");
            $alluser = count($scan) - 2;
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    • نوع ربات : اختصاصی 💳
    • وضعیت ربات : $online
    • تعداد کاربران : $alluser کاربر
    ",


            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "➕ افزایش پول") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "💳 لطفا مبلغ مورد نظرتون رو با اعداد انگلیسی و به ریال وارد کنید :",
                'reply_markup' => $bk,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "plus");
        }
        if ($step == "plus" and $text != $oo) {
            file_put_contents("data/plus", $text);
            sendmessage($chat_id, "🔢 اکنون ایدی عددی کاربر مورد نظر را وارد کنید .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "plus1");
        }
        if ($step == "plus1" and $text != $o) {
            $coink = file_get_contents("data/user/$text/coin.txt");
            $a = file_get_contents("data/plus");
            $aTooman = $a / 10;
            $b = $coink + $a;
            sendmessage($chat_id, "✅ با موفقیت انجام شد .");
            file_put_contents("data/user/$text/coin.txt", $b);
            sendmessage($text, "
    💳 از طرف مدیریت مبلغ $aTooman تومان برای ما فرستاده شد .
    ");
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "➖ کاهش پول") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "💳 لطفا مبلغ مورد نظرتون رو با اعداد انگلیسی و به ریال وارد کنید :",
                'reply_markup' => $bk,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "pluss");
        }
        if ($step == "pluss" and $text != $oo) {
            file_put_contents("data/plus", $text);
            sendmessage($chat_id, "🔢 اکنون ایدی عددی کاربر مورد نظر را وارد کنید .", $bk);
            file_put_contents("data/user/$from_id/step.txt", "pluss1");
        }
        if ($step == "pluss1" and $text != $o) {
            $coink = file_get_contents("data/user/$text/coin.txt");
            $a = file_get_contents("data/plus");
            $b = $coink - $a;
            sendmessage($chat_id, "✅ با موفقیت انجام شد .");
            file_put_contents("data/user/$text/coin.txt", $b);
            sendmessage($text, "
    💳 از طرف مدیریت مبلغ $a ریال از ما کم شد .
    ");
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        #-----------------------------#
        #-----------------------------#
        if ($text == "🔑 خدمات ارسال") {
            $key6 = json_encode(['keyboard' => [
                [['text' => "📥 فوروارد همگانی"], ['text' => "📤 ارسال همگانی"]],
                [['text' => "$oo"]],
            ], 'resize_keyboard' => true]);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "
    🛡 یکی از خدمات موجود را انتخاب کنید :
    ",
                'reply_markup' => $key6,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "💳 تنظیمات مالی") {
            $key7 = json_encode(['keyboard' => [
                [['text' => "💳ثبت شماره کارت"]],
                [['text' => "➖ کاهش پول"], ['text' => "➕ افزایش پول"]],
                [['text' => "💵 پول همگانی"], ['text' => "🏵ساخت کد هدیه"]],
                [['text' => "ساخت کد تخفیف"], ['text' => "حذف کد تخفیف"]],
                [['text' => "$oo"]]
            ], 'resize_keyboard' => true]);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "🔑 یکی از خدمات موجود را انتخاب کنید :",
                'reply_markup' => $key7,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "📤 ارسال همگانی") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "📣 متن مورد نظرتون رو برای من ارسال کنید :",
                'reply_markup' => $bk,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "senall");
        }
        if ($step == "senall" and $text != $oo) {
            if ($text) {
                $allmmber = scandir("data/user");
                foreach ($allmmber as $member) {
                    if(intval($member) !== 0) {
                        sendmessage($member, $text);
                    }
                }
                sendmessage($chat_id, "✅ پیام شما با موفقیت ارسال شد ‌.");
            } else {
                sendmessage($chat_id, "🖊 شما فقط میتوانید متن ارسال کنید .");
            }
        }
        #-----------------------------#
        if ($text == "📥 فوروارد همگانی") {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "📣 رسانه مورد نظرتون رو برای من ارسال کنید :",
                'reply_markup' => $bk,


            ]);
            file_put_contents("data/user/$from_id/step.txt", "senalll");
        }
        if ($step == "senalll" and $text != $oo) {
            $allmmber = scandir("data/user");
            foreach ($allmmber as $sendall) {
                if(intval($sendall) !== 0) {
                    bot('forwardMessage', [
                        'from_chat_id' => $from_id,
                        'message_id' => $message_id,
                        'chat_id' => $sendall,
                    ]);
                }
            }
            sendmessage($chat_id, "✅ پیام شما با موفقیت ارسال شد ‌.");
        }
        #-----------------------------#
        if ($text == "🎺 تنظیمات کانال") {
            $keykhoda = json_encode(['keyboard' => [
                [['text' => "خاموش|روشن قفل"], ['text' => "ست کانال"]],
                [['text' => "$oo"]],
            ], 'resize_keyboard' => true]);
            sendmessage($chat_id, "⚙ یکی از وضعیت های موجود را انتخاب کنید :", $keykhoda);
        }
        if ($text == "خاموش|روشن قفل") {
            if ($pooyaosm == "خاموش") {
                file_put_contents("data/osm", "روشن");
                sendmessage($chat_id, "🔑قفل جوین اجباری کانال فعال شد .");
                file_put_contents("data/user/$from_id/step.txt", "none");
            } else {
                file_put_contents("data/osm", "خاموش");
                sendmessage($chat_id, "🔑قفل جوین اجباری کانال غیر فعال شد .");
                file_put_contents("data/user/$from_id/step.txt", "none");
            }
        }
        #-----------------------------#
        if ($text == "❌ حذف کل اکانتها") {
            DeleteDirectory("data/vpn");
            DeleteDirectory("data/@Legend_botmaker");
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "✅ تمام اکانت های ثبت شده برای فروش از سرور ربات پاک شدند ‌.",


            ]);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "⚙ تنظیمات مدیریتی") {
            $key8 = json_encode(['keyboard' => [
                [['text' => "🎺 تنظیمات کانال"], ['text' => "✂️خاموش|روشن"]],
                [['text' => "✅ آزاد کردن"], ['text' => "⛔️ مسدود کردن"]],
                [['text' => "$oo"]],
            ], 'resize_keyboard' => true]);

            sendmessage($chat_id, "👑 یکی از تنظیمات موجود را انتخاب کنید :", $key8);
            file_put_contents("data/user/$from_id/step.txt", "none");
        }
        #-----------------------------#
        if ($text == "⛔️ مسدود کردن") {
            sendmessage($chat_id, "👌 - آیدی عددی کاربری که قصد دارید از ربات آن را مسدود کنید وارد کنید :", $bk);
            file_put_contents("data/user/$from_id/step.txt", "okban");
        }
        if ($step == "okban" and $text != $oo) {
            if (!is_dir("data/user/$text")) {
                sendmessage($chat_id, "این کاربر در ربات وجود ندارد .", $bk);
                file_put_contents("data/user/$from_id/step.txt", "none");
                exit();
            }
            if ($text == $dev) {
                sendmessage($chat_id, "شما نمیتوانید ادمین ربات را مسدود کنید .", $bk);
                file_put_contents("data/user/$from_id/step.txt", "none");
                exit();
            } else {
                file_put_contents("data/user/$text/ban.txt", "ok");
                sendmessage($chat_id, "😘 - کاربر با ایدی $text از ربات مسدود شد .", $bk);
                sendmessage($text, "متأسفانه شما از ربات مسدود شدید.");
                file_put_contents("data/user/$from_id/step.txt", "none");
            }
        }

        if ($text == "✅ آزاد کردن") {
            sendmessage($chat_id, "👌 - آیدی عددی کاربری که قصد دارید از ربات آن را آزاد کنید وارد کنید :", $bk);
            file_put_contents("data/user/$from_id/step.txt", "okunban");
        }
        if ($step == "okunban" and $text != $oo) {
            if (!is_dir("data/user/$text")) {
                sendmessage($chat_id, "این کاربر در ربات وجود ندارد .", $bk);
                file_put_contents("data/user/$from_id/step.txt", "none");
                exit();
            }
            if ($text == $dev) {
                sendmessage($chat_id, "شما نمیتوانید ادمین ربات را رفع مسدودی کنید .", $bk);
                file_put_contents("data/user/$from_id/step.txt", "none");
                exit();
            } else {
                file_put_contents("data/user/$text/ban.txt", "no");
                sendmessage($chat_id, "😘 - کاربر با ایدی $text از ربات آزاد شد .", $bk);
                sendmessage($text, "شما از ربات آزاد شدید و دیگر مسدود نیستید .");
                file_put_contents("data/user/$from_id/step.txt", "none");
            }
        }
        #-----------------------------#
        if ($text == "💵 پول همگانی") {
            sendmessage($chat_id, "🪙 لطفا مبلغ را به ریال و با اعداد انگلیسی وارد کنید :", $bk);
            file_put_contents("data/user/$from_id/step.txt", "cow");
        }
        if ($step == "cow" and $text != $oo) {
            $allmmber = scandir("data/user");
            $aTooman = intval($a) / 10;
            foreach ($allmmber as $alluser) {
                $a = file_get_contents("data/user/$alluser/coin.txt");
                $b = $a + $text;
                file_put_contents("data/user/$alluser/coin.txt", $b);
                sendmessage($alluser, "💸 از طرف مدیریت مبلغ $aTooman تومان به صورت #همگانی به ما تعلق گرفت .");
            }
            sendmessage($chat_id, "📤 مبلغ $aTooman تومان به همه ی کاربران ربات ارسال شد .");
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        #-----------------------------#
        if ($text == "🏵ساخت کد هدیه") {
            sendmessage($chat_id, "مبلغ کد هدیه را همراه با تعداد موجود به این صورت وارد کنید:\n\nMablagh Tedad \nمثال:\n 200000 10", $bk);
            file_put_contents("data/user/$from_id/step.txt", "okpooya");
        }
        if ($step == "okpooya" and $text != $oo) {
            $amounts = explode(" ", $text);
            if(count($amounts) == 2) {
                if(intval($amounts[0] !== 0 && intval($amounts[1]) !== 0)) {
                    $rand = rand(10000, 100000);
                    file_put_contents("data/code/$rand", "$amounts[0] $amounts[1]");
                    sendmessage($chat_id, "کد هدیه ساخته شده : $rand");
                    file_put_contents("data/user/$from_id/step.txt", "none");
                } else {
                    sendmessage($chat_id, "ورودی اشتباه است،\nمبلغ کد هدیه را همراه با تعداد موجود به این صورت وارد کنید:\n\nMablagh Tedad \nمثال: 200000 10", $bk);
                }
            } else {
                sendmessage($chat_id, "ورودی اشتباه است،\nمبلغ کد هدیه را همراه با تعداد موجود به این صورت وارد کنید:\n\nMablagh Tedad \nمثال: 200000 10", $bk);
            }
        }
        #-----------------------------#

        #-----------------------------#
        if ($text == "ساخت کد تخفیف") {
            sendmessage($chat_id, "درصد کد تخفیف را این صورت وارد کنید:\n\n50", $bk);
            file_put_contents("data/user/$from_id/step.txt", "okpooya2");
        }
        if ($step == "okpooya2" and $text != $oo) {
            if ( intval($text) !== 0 && intval($text) >= 1 && intval($text) <= 100) {
                $rand = rand(10000, 100000);
                file_put_contents("data/code2/$rand", intval($text) / 100);
                sendmessage($chat_id, "کد تخفیف ساخته شده : $rand");
                file_put_contents("data/user/$from_id/step.txt", "none");
            } else {
                sendmessage($chat_id, "درصد باید بصورت عدد انگلیسی و بین یا مساوی 1 و 100 باشد.\nدرصد کد تخفیف را این صورت وارد کنید:\n\n50", $bk);
            }
        }
        if ($text == "حذف کد تخفیف") {
            sendmessage($chat_id, "🤖 کد تخفیف مورد نظر را برای حذف ارسال کنید:", $bk);
            file_put_contents("data/user/$from_id/step.txt", "deleteDiscount");
        }
        if($step == "deleteDiscount" && $text != $oo) {
            $discountCode = $text;
            if(file_exists("data/code2/$discountCode")) {
                unlink("data/code2/$discountCode");
                sendmessage($chat_id, "✅ کد تخفیف مورد نظر با موفقیت حذف شد.", $bk);
                file_put_contents("data/user/$from_id/step.txt", "none");
            } else {
                sendmessage($chat_id, "❌ کد مورد نظر در سیستم وجود نداره، یکی دیگه بفرست", $bk);
            }
        }
            #-----------------------------#

        if ($text == "ست کانال") {

            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "آیدی کانال خود را بدون @ ارسال کنید .",
                'reply_markup' => $bk,
            ]);

            file_put_contents("data/user/$from_id/step.txt", "setidok");
        }

        if ($step == "setidok" and $text != $oo) {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "کانال @$text با موفقیت ذخیره شد",
                'reply_markup' => $bk,
            ]);
            file_put_contents("data/channel", "$text");
            file_put_contents("data/user/$from_id/step.txt", "none");
        }

        #-----------------------------#
        if ($text == "✂️خاموش|روشن") {
            if ($online == "🟢روشن") {
                sendmessage($chat_id, "🔴ربات با موفقیت خاموش شد");
                if (!is_dir("data/setting")) {
                    mkdir("data/setting");
                }
                file_put_contents("data/setting/online.txt", "🔴خاموش");
            } else {
                sendmessage($chat_id, "🟢ربات با موفقیت روشن شد.");
                if (!is_dir("data/setting")) {
                    mkdir("data/setting");
                }
                file_put_contents("data/setting/online.txt", "🟢روشن");
            }
        }
        #-----------------------------#
        if ($text == "🐣[خاموش|روشن] گردونه شانس") {
            if ($gar == "on") {
                sendmessage($chat_id, "🏷گردونه شانس خاموش شد .");
                file_put_contents("data/setting/gar.txt", "off");
            } else {
                sendmessage($chat_id, "🥷گردونه شانس روشن شد .");
                file_put_contents("data/setting/gar.txt", "on");
            }
        }
        #-----------------------------#
        if ($text == "🧑‍💻پشتیبان") {
            sendmessage($chat_id, "اپدیت اینده اضافه می شود .");
        }
        #-----------------------------#
        if ($text == "📖راهنما") {
            sendmessage($chat_id, "اپدیت اینده اضافه می شود .");
        }
        #-----------------------------#

    } //

    if ($text == $m1 && !isset($query_id)) {

        $open = file_get_contents("data/vpn/$m1/buy");
        if (file_exists("data/user/$chat_id/discount.txt")) {
            $open -= floatval(file_get_contents("data/user/$chat_id/discount.txt")) * $open;
        }
        $scan  = scandir("data/vpn/$m1/code");
        $count = count($scan) - 2;
        $okadmin = "#گزارش_هوشمند \n\n ❌ محصولات سرویس با نام ($m1) به اتمام رسیده است . لطفا اقدامات لازم را انجام دهید .";

        if ($coin < $open) {
            $neededCoin = $open - intval($coin);
            $openTooman = number_format(intval($open) / 10);
            $coinTooman = number_format(intval($coin) / 10);
            $neededCoinTooman = number_format($neededCoin / 10);
            sendmessage($chat_id, "❌ موجودی شما جهت خرید این محصول کافی نیست ! \n حساب خود را شارژ کنید:\nقیمت سرویس: $openTooman تومان\nکیف پول شما: $coinTooman تومان\n\nهزینه مورد نیاز: $neededCoinTooman تومان", $paymentMethods);
            exit();
        }

        if ($count == 0) {

            sendmessage($chat_id, "📂 متاسفانه محصولات این سرویس به اتمام رسیده است لطفا بعدا مراجعه کنید .", $back);
            sendmessage($dev, $okadmin);
            sendmessage($admin, $okadmin);
            exit();
        } else {

            $kasr = $coin - $open;
            file_put_contents("data/user/$from_id/coin.txt", $kasr);
            $scans = scandir("data/vpn/$m1/code");
            $random = $scans[rand(2, count($scans) - 1)];
            $getconfig = file_get_contents("data/vpn/$m1/code/$random");
        }

        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$getconfig`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $back,
        ]);
        addConfig($getconfig, $chat_id);
        unlink("data/vpn/$m1/code/$random");
        if(file_exists("data/user/$chat_id/discount.txt")) {
            unlink("data/user/$chat_id/discount.txt");
        }
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }

    if ($text == $m2 && !isset($query_id)) {

        $open = file_get_contents("data/vpn/$m2/buy");
        if (file_exists("data/user/$chat_id/discount.txt")) {
            $open -= floatval(file_get_contents("data/user/$chat_id/discount.txt")) * $open;
        }
        $scan  = scandir("data/vpn/$m2/code");
        $count = count($scan) - 2;
        $okadmin = "#گزارش_هوشمند \n\n ❌ محصولات سرویس با نام ($m2) به اتمام رسیده است . لطفا اقدامات لازم را انجام دهید .";

        if ($coin < $open) {
            $neededCoin = $open - intval($coin);
            $openTooman = number_format(intval($open) / 10);
            $coinTooman = number_format(intval($coin) / 10);
            $neededCoinTooman = number_format($neededCoin / 10);
            sendmessage($chat_id, "❌ موجودی شما جهت خرید این محصول کافی نیست ! \n حساب خود را شارژ کنید:\nقیمت سرویس: $openTooman تومان\nکیف پول شما: $coinTooman تومان\n\nهزینه مورد نیاز: $neededCoinTooman تومان", $paymentMethods);
            exit();
        }

        if ($count == 0) {

            sendmessage($chat_id, "📂 متاسفانه محصولان این سرویس به اتمام رسیده است لطفا بعدا مراجعه کنید .", $back);
            sendmessage($dev, $okadmin);
            sendmessage($admin, $okadmin);
            exit();
        } else {

            $kasr = $coin - $open;
            file_put_contents("data/user/$from_id/coin.txt", $kasr);
            $scans = scandir("data/vpn/$m2/code");
            $random = $scans[rand(2, count($scans) - 1)];
            $getconfig = file_get_contents("data/vpn/$m2/code/$random");
        }

        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$getconfig`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $back,
        ]);
        addConfig($getconfig, $chat_id);
        unlink("data/vpn/$m2/code/$random");
        if(file_exists("data/user/$chat_id/discount.txt")) {
            unlink("data/user/$chat_id/discount.txt");
        }
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }

    if ($text == $m3 && !isset($query_id)) {

        $open = file_get_contents("data/vpn/$m3/buy");
        if (file_exists("data/user/$chat_id/discount.txt")) {
            $open -= floatval(file_get_contents("data/user/$chat_id/discount.txt")) * $open;
        }
        $scan  = scandir("data/vpn/$m3/code");
        $count = count($scan) - 2;
        $okadmin = "#گزارش_هوشمند \n\n ❌ محصولات سرویس با نام ($m3) به اتمام رسیده است . لطفا اقدامات لازم را انجام دهید .";

        if ($coin < $open) {
            $neededCoin = $open - intval($coin);
            $openTooman = number_format(intval($open) / 10);
            $coinTooman = number_format(intval($coin) / 10);
            $neededCoinTooman = number_format($neededCoin / 10);
            sendmessage($chat_id, "❌ موجودی شما جهت خرید این محصول کافی نیست ! \n حساب خود را شارژ کنید:\nقیمت سرویس: $openTooman تومان\nکیف پول شما: $coinTooman تومان\n\nهزینه مورد نیاز: $neededCoinTooman تومان", $paymentMethods);
            exit();
        }

        if ($count == 0) {

            sendmessage($chat_id, "📂 متاسفانه محصولان این سرویس به اتمام رسیده است لطفا بعدا مراجعه کنید .", $back);
            sendmessage($dev, $okadmin);
            sendmessage($admin, $okadmin);
            exit();
        } else {

            $kasr = $coin - $open;
            file_put_contents("data/user/$from_id/coin.txt", $kasr);
            $scans = scandir("data/vpn/$m3/code");
            $random = $scans[rand(2, count($scans) - 1)];
            $getconfig = file_get_contents("data/vpn/$m3/code/$random");
        }

        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$getconfig`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $back,
        ]);
        addConfig($getconfig, $chat_id);
        unlink("data/vpn/$m3/code/$random");
        if(file_exists("data/user/$chat_id/discount.txt")) {
            unlink("data/user/$chat_id/discount.txt");
        }
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }

    if ($text == $m4 && !isset($query_id)) {

        $open = file_get_contents("data/vpn/$m4/buy");
        if (file_exists("data/user/$chat_id/discount.txt")) {
            $open -= floatval(file_get_contents("data/user/$chat_id/discount.txt")) * $open;
        }
        $scan  = scandir("data/vpn/$m4/code");
        $count = count($scan) - 2;
        $okadmin = "#گزارش_هوشمند \n\n ❌ محصولات سرویس با نام ($m4) به اتمام رسیده است . لطفا اقدامات لازم را انجام دهید .";

        if ($coin < $open) {
            $neededCoin = $open - intval($coin);
            $openTooman = number_format(intval($open) / 10);
            $coinTooman = number_format(intval($coin) / 10);
            $neededCoinTooman = number_format($neededCoin / 10);
            sendmessage($chat_id, "❌ موجودی شما جهت خرید این محصول کافی نیست ! \n حساب خود را شارژ کنید:\nقیمت سرویس: $openTooman تومان\nکیف پول شما: $coinTooman تومان\n\nهزینه مورد نیاز: $neededCoinTooman تومان", $paymentMethods);
            exit();
        }

        if ($count == 0) {

            sendmessage($chat_id, "📂 متاسفانه محصولان این سرویس به اتمام رسیده است لطفا بعدا مراجعه کنید .", $back);
            sendmessage($dev, $okadmin);
            sendmessage($admin, $okadmin);
            exit();
        } else {

            $kasr = $coin - $open;
            file_put_contents("data/user/$from_id/coin.txt", $kasr);
            $scans = scandir("data/vpn/$m4/code");
            $random = $scans[rand(2, count($scans) - 1)];
            $getconfig = file_get_contents("data/vpn/$m4/code/$random");
        }

        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$getconfig`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $back,
        ]);
        addConfig($getconfig, $chat_id);
        unlink("data/vpn/$m4/code/$random");
        if(file_exists("data/user/$chat_id/discount.txt")) {
            unlink("data/user/$chat_id/discount.txt");
        }
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }

    if ($text == $m5 && !isset($query_id)) {

        $open = file_get_contents("data/vpn/$m5/buy");
        if (file_exists("data/user/$chat_id/discount.txt")) {
            $open -= floatval(file_get_contents("data/user/$chat_id/discount.txt")) * $open;
        }
        $scan  = scandir("data/vpn/$m5/code");
        $count = count($scan) - 2;
        $okadmin = "#گزارش_هوشمند \n\n ❌ محصولات سرویس با نام ($m5) به اتمام رسیده است . لطفا اقدامات لازم را انجام دهید .";

        if ($coin < $open) {
            $neededCoin = $open - intval($coin);
            $openTooman = number_format(intval($open) / 10);
            $coinTooman = number_format(intval($coin) / 10);
            $neededCoinTooman = number_format($neededCoin / 10);
            sendmessage($chat_id, "❌ موجودی شما جهت خرید این محصول کافی نیست ! \n حساب خود را شارژ کنید:\nقیمت سرویس: $openTooman تومان\nکیف پول شما: $coinTooman تومان\n\nهزینه مورد نیاز: $neededCoinTooman تومان", $paymentMethods);
            exit();
        }

        if ($count == 0) {

            sendmessage($chat_id, "📂 متاسفانه محصولان این سرویس به اتمام رسیده است لطفا بعدا مراجعه کنید .", $back);
            sendmessage($dev, $okadmin);
            sendmessage($admin, $okadmin);
            exit();
        } else {

            $kasr = $coin - $open;
            file_put_contents("data/user/$from_id/coin.txt", $kasr);
            $scans = scandir("data/vpn/$m5/code");
            $random = $scans[rand(2, count($scans) - 1)];
            $getconfig = file_get_contents("data/vpn/$m5/code/$random");
        }

        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$getconfig`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $back,
        ]);
        addConfig($getconfig, $chat_id);
        unlink("data/vpn/$m5/code/$random");
        if(file_exists("data/user/$chat_id/discount.txt")) {
            unlink("data/user/$chat_id/discount.txt");
        }
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }

    if ($text == $m6 && !isset($query_id)) {

        $open = file_get_contents("data/vpn/$m6/buy");
        if (file_exists("data/user/$chat_id/discount.txt")) {
            $open -= floatval(file_get_contents("data/user/$chat_id/discount.txt")) * $open;
        }
        $scan  = scandir("data/vpn/$m6/code");
        $count = count($scan) - 2;
        $okadmin = "#گزارش_هوشمند \n\n ❌ محصولات سرویس با نام ($m6) به اتمام رسیده است . لطفا اقدامات لازم را انجام دهید .";

        if ($coin < $open) {
            $neededCoin = $open - intval($coin);
            $openTooman = number_format(intval($open) / 10);
            $coinTooman = number_format(intval($coin) / 10);
            $neededCoinTooman = number_format($neededCoin / 10);
            sendmessage($chat_id, "❌ موجودی شما جهت خرید این محصول کافی نیست ! \n حساب خود را شارژ کنید:\nقیمت سرویس: $openTooman تومان\nکیف پول شما: $coinTooman تومان\n\nهزینه مورد نیاز: $neededCoinTooman تومان", $paymentMethods);
            exit();
        }

        if ($count == 0) {

            sendmessage($chat_id, "📂 متاسفانه محصولان این سرویس به اتمام رسیده است لطفا بعدا مراجعه کنید .", $back);
            sendmessage($dev, $okadmin);
            sendmessage($admin, $okadmin);
            exit();
        } else {

            $kasr = $coin - $open;
            file_put_contents("data/user/$from_id/coin.txt", $kasr);
            $scans = scandir("data/vpn/$m6/code");
            $random = $scans[rand(2, count($scans) - 1)];
            $getconfig = file_get_contents("data/vpn/$m6/code/$random");
        }

        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$getconfig`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $back,
        ]);
        addConfig($getconfig, $chat_id);
        unlink("data/vpn/$m6/code/$random");
        if(file_exists("data/user/$chat_id/discount.txt")) {
            unlink("data/user/$chat_id/discount.txt");
        }
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }

    if ($text == $m7 && !isset($query_id)) {

        $open = file_get_contents("data/vpn/$m7/buy");
        if (file_exists("data/user/$chat_id/discount.txt")) {
            $open -= floatval(file_get_contents("data/user/$chat_id/discount.txt")) * $open;
        }
        $scan  = scandir("data/vpn/$m7/code");
        $count = count($scan) - 2;
        $okadmin = "#گزارش_هوشمند \n\n ❌ محصولات سرویس با نام ($m1) به اتمام رسیده است . لطفا اقدامات لازم را انجام دهید .";

        if ($coin < $open) {
            $neededCoin = $open - intval($coin);
            $openTooman = number_format(intval($open) / 10);
            $coinTooman = number_format(intval($coin) / 10);
            $neededCoinTooman = number_format($neededCoin / 10);
            sendmessage($chat_id, "❌ موجودی شما جهت خرید این محصول کافی نیست ! \n حساب خود را شارژ کنید:\nقیمت سرویس: $openTooman تومان\nکیف پول شما: $coinTooman تومان\n\nهزینه مورد نیاز: $neededCoinTooman تومان", $paymentMethods);
            exit();
        }

        if ($count == 0) {

            sendmessage($chat_id, "📂 متاسفانه محصولان این سرویس به اتمام رسیده است لطفا بعدا مراجعه کنید .", $back);
            sendmessage($dev, $okadmin);
            sendmessage($admin, $okadmin);
            exit();
        } else {

            $kasr = $coin - $open;
            file_put_contents("data/user/$from_id/coin.txt", $kasr);
            $scans = scandir("data/vpn/$m7/code");
            $random = $scans[rand(2, count($scans) - 1)];
            $getconfig = file_get_contents("data/vpn/$m7/code/$random");
        }

        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$getconfig`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $back,
        ]);
        addConfig($getconfig, $chat_id);
        unlink("data/vpn/$m7/code/$random");
        if(file_exists("data/user/$chat_id/discount.txt")) {
            unlink("data/user/$chat_id/discount.txt");
        }
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }

    if ($text == $m8 && !isset($query_id)) {

        $open = file_get_contents("data/vpn/$m8/buy");
        if (file_exists("data/user/$chat_id/discount.txt")) {
            $open -= floatval(file_get_contents("data/user/$chat_id/discount.txt")) * $open;
        }
        $scan  = scandir("data/vpn/$m8/code");
        $count = count($scan) - 2;
        $okadmin = "#گزارش_هوشمند \n\n ❌ محصولات سرویس با نام ($m8) به اتمام رسیده است . لطفا اقدامات لازم را انجام دهید .";

        if ($coin < $open) {
            $neededCoin = $open - intval($coin);
            $openTooman = number_format(intval($open) / 10);
            $coinTooman = number_format(intval($coin) / 10);
            $neededCoinTooman = number_format($neededCoin / 10);
            sendmessage($chat_id, "❌ موجودی شما جهت خرید این محصول کافی نیست ! \n حساب خود را شارژ کنید:\nقیمت سرویس: $openTooman تومان\nکیف پول شما: $coinTooman تومان\n\nهزینه مورد نیاز: $neededCoinTooman تومان", $paymentMethods);
            exit();
        }

        if ($count == 0) {

            sendmessage($chat_id, "📂 متاسفانه محصولان این سرویس به اتمام رسیده است لطفا بعدا مراجعه کنید .", $back);
            sendmessage($dev, $okadmin);
            sendmessage($admin, $okadmin);
            exit();
        } else {

            $kasr = $coin - $open;
            file_put_contents("data/user/$from_id/coin.txt", $kasr);
            $scans = scandir("data/vpn/$m8/code");
            $random = $scans[rand(2, count($scans) - 1)];
            $getconfig = file_get_contents("data/vpn/$m8/code/$random");
        }

        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$getconfig`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $back,
        ]);
        addConfig($getconfig, $chat_id);
        unlink("data/vpn/$m8/code/$random");
        if(file_exists("data/user/$chat_id/discount.txt")) {
            unlink("data/user/$chat_id/discount.txt");
        }
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }

    if ($text == $m9 && !isset($query_id)) {

        $open = file_get_contents("data/vpn/$m9/buy");
        if (file_exists("data/user/$chat_id/discount.txt")) {
            $open -= floatval(file_get_contents("data/user/$chat_id/discount.txt")) * $open;
        }
        $scan  = scandir("data/vpn/$m9/code");
        $count = count($scan) - 2;
        $okadmin = "#گزارش_هوشمند \n\n ❌ محصولات سرویس با نام ($m9) به اتمام رسیده است . لطفا اقدامات لازم را انجام دهید .";

        if ($coin < $open) {
            $neededCoin = $open - intval($coin);
            $openTooman = number_format(intval($open) / 10);
            $coinTooman = number_format(intval($coin) / 10);
            $neededCoinTooman = number_format($neededCoin / 10);
            sendmessage($chat_id, "❌ موجودی شما جهت خرید این محصول کافی نیست ! \n حساب خود را شارژ کنید:\nقیمت سرویس: $openTooman تومان\nکیف پول شما: $coinTooman تومان\n\nهزینه مورد نیاز: $neededCoinTooman تومان", $paymentMethods);
            exit();
        }

        if ($count == 0) {

            sendmessage($chat_id, "📂 متاسفانه محصولان این سرویس به اتمام رسیده است لطفا بعدا مراجعه کنید .", $back);
            sendmessage($dev, $okadmin);
            sendmessage($admin, $okadmin);
            exit();
        } else {

            $kasr = $coin - $open;
            file_put_contents("data/user/$from_id/coin.txt", $kasr);
            $scans = scandir("data/vpn/$m9/code");
            $random = $scans[rand(2, count($scans) - 1)];
            $getconfig = file_get_contents("data/vpn/$m9/code/$random");
        }

        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$getconfig`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $back,
        ]);
        addConfig($getconfig, $chat_id);
        unlink("data/vpn/$m9/code/$random");
        if(file_exists("data/user/$chat_id/discount.txt")) {
            unlink("data/user/$chat_id/discount.txt");
        }
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }

    if ($text == $m10 && !isset($query_id)) {

        $open = file_get_contents("data/vpn/$m10/buy");
        if (file_exists("data/user/$chat_id/discount.txt")) {
            $open -= floatval(file_get_contents("data/user/$chat_id/discount.txt")) * $open;
        }
        $scan  = scandir("data/vpn/$m10/code");
        $count = count($scan) - 2;
        $okadmin = "#گزارش_هوشمند \n\n ❌ محصولات سرویس با نام ($m10) به اتمام رسیده است . لطفا اقدامات لازم را انجام دهید .";

        if ($coin < $open) {
            $neededCoin = $open - intval($coin);
            $openTooman = number_format(intval($open) / 10);
            $coinTooman = number_format(intval($coin) / 10);
            $neededCoinTooman = number_format($neededCoin / 10);
            sendmessage($chat_id, "❌ موجودی شما جهت خرید این محصول کافی نیست ! \n حساب خود را شارژ کنید:\nقیمت سرویس: $openTooman تومان\nکیف پول شما: $coinTooman تومان\n\nهزینه مورد نیاز: $neededCoinTooman تومان", $paymentMethods);
            exit();
        }

        if ($count == 0) {

            sendmessage($chat_id, "📂 متاسفانه محصولان این سرویس به اتمام رسیده است لطفا بعدا مراجعه کنید .", $back);
            sendmessage($dev, $okadmin);
            sendmessage($admin, $okadmin);
            exit();
        } else {

            $kasr = $coin - $open;
            file_put_contents("data/user/$from_id/coin.txt", $kasr);
            $scans = scandir("data/vpn/$m10/code");
            $random = $scans[rand(2, count($scans) - 1)];
            $getconfig = file_get_contents("data/vpn/$m10/code/$random");
        }

        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
    🟢 • کد شما با موفقیت ساخته شد .

    `$getconfig`

    • با کلیک روی کد کانکشن به صورت خودکار برای شما کپی می شود .
    ",
            'parse_mode' => "Markdown",
            'reply_markup' => $back,
        ]);
        addConfig($getconfig, $chat_id);
        unlink("data/vpn/$m10/code/$random");
        if(file_exists("data/user/$chat_id/discount.txt")) {
            unlink("data/user/$chat_id/discount.txt");
        }
        file_put_contents("data/user/$from_id/step.txt", "none");
        exit();
    }
    #-----------------------------#
    #-----------------------------#
 ///   اوپن کردن این سورس باعث اشنا شدن شما با پدر اصلی تان است ///
////    نوشته شده توسط : @i_tekin///
    #-----------------------------#
