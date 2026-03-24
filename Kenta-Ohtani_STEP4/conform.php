<?php
// POSTデータを受け取る
$data = $_POST;
$errors = [];

// --- バリデーションロジック ---

// 1. name: ひらがな、カタカナ、漢字、英字のみ
if (empty($data['name'])) {
    $errors[] = 'required';
} elseif (!preg_match('/^[a-zA-Z\p{Hiragana}\p{Katakana}\p{Han}]+$/u', $data['name'])) {
    $errors[] = 'name';
}

// 2. age: 0から150の間
// filter_var(..., FILTER_VALIDATE_INT)で整数と範囲をチェック
if (empty($data['age']) && $data['age'] !== '0') {
    $errors[] = 'required';
} elseif (!filter_var($data['age'], FILTER_VALIDATE_INT, array("options" => array("min_range" => 0, "max_range" => 150)))) {
    $errors[] = 'age';
}

// 3. phone: 半角数字とハイフンのみ
if (empty($data['phone'])) {
    $errors[] = 'required';
} elseif (!preg_match('/^[0-9-]+$/', $data['phone'])) {
    $errors[] = 'phone';
}

// 4. email: メールアドレス形式
if (empty($data['email'])) {
    $errors[] = 'required';
} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'email';
}

// 5. address: ひらがな、カタカナ、漢字、英字のみ
if (empty($data['address'])) {
    $errors[] = 'required';
} elseif (!preg_match('/^[a-zA-Z\p{Hiragana}\p{Katakana}\p{Han}]+$/u', $data['address'])) {
    // 住所で数字やハイフンを使いたい場合は、正規表現を調整する必要がありますが、
    // ここでは指定通り「ひらがな、カタカナ、漢字、英字」に厳密に従います。
    $errors[] = 'address';
}

// --- エラー処理 (リダイレクト) ---
if (!empty($errors)) {
    // エラーメッセージと入力値をGETパラメータとしてform.phpにリダイレクト
    $error_list = implode(',', array_unique($errors));
    $query_params = http_build_query(array_merge($data, ['error' => $error_list]));
    header("Location: form.php?" . $query_params);
    exit;
}

// --- 成功時の表示準備 ---

// 性別の表示名変換
$gender_display = '未入力';
$gender = $data['gender'];
if ($gender === 'male') {
    $gender_display = '男性';
} elseif ($gender === 'female') {
    $gender_display = '女性';
} elseif ($gender === 'other') {
    $gender_display = 'その他';
} elseif ($gender === 'unselected') {
    $gender_display = '未選択';
}

// 表示用にHTMLエスケープ
$name_output = htmlspecialchars($data['name']);
$age_output = htmlspecialchars($data['age']);
$phone_output = htmlspecialchars($data['phone']);
$email_output = htmlspecialchars($data['email']);
$address_output = htmlspecialchars($data['address']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ内容確認</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>お問い合わせ内容確認</h1>
    
    <div class="container">
        <div class="confirm-item">
            <p class="label">お名前:</p>
            <p class="value"><?php echo $name_output; ?></p>
        </div>
        <div class="confirm-item">
            <p class="label">年齢:</p>
            <p class="value"><?php echo $age_output; ?></p>
        </div>
        <div class="confirm-item">
            <p class="label">電話番号:</p>
            <p class="value"><?php echo $phone_output; ?></p>
        </div>
        <div class="confirm-item">
            <p class="label">メールアドレス:</p>
            <p class="value"><?php echo $email_output; ?></p>
        </div>
        <div class="confirm-item">
            <p class="label">住所:</p>
            <p class="value"><?php echo $address_output; ?></p>
        </div>
        <div class="confirm-item">
            <p class="label">性別:</p>
            <p class="value"><?php echo $gender_display; ?></p>
        </div>

        <form action="form.php" method="get" class="button-group">
            <button type="submit">戻る</button>
        </form>
    </div>
</body>
</html>