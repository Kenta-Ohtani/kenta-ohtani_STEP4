<?php
// バリデーションエラーと前回の入力値をGETパラメータから取得
$errors = isset($_GET['error']) ? explode(',', $_GET['error']) : [];
$old_data = [
    'name' => isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '',
    'age' => isset($_GET['age']) ? htmlspecialchars($_GET['age']) : '',
    'phone' => isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : '',
    'email' => isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '',
    'address' => isset($_GET['address']) ? htmlspecialchars($_GET['address']) : '',
    'gender' => isset($_GET['gender']) ? htmlspecialchars($_GET['gender']) : 'unselected',
];

// エラーキーと表示メッセージの対応
$error_map = [
    'name' => 'お名前: 名前はひらがな、カタカナ、漢字、英字のみ使用できます。',
    'age' => '年齢: 年齢は0から150の間で入力してください。',
    'phone' => '電話番号: 電話番号は半角数字とハイフンのみ使用できます。',
    'email' => 'メールアドレス: メールアドレスの形式が正しくありません。',
    'address' => '住所: 住所はひらがな、カタカナ、漢字、英字のみ使用できます。',
    'required' => '必須項目が未入力です。', // 汎用的な未入力エラー
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせフォーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>フォーム入力</h1>
    
    <?php if (!empty($errors)): ?>
    <div class="error-messages container">
        <h2>入力内容にエラーがあります</h2>
        <?php foreach (array_unique($errors) as $error_key): ?>
            <?php if (isset($error_map[$error_key])): ?>
                <p><?php echo $error_map[$error_key]; ?></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <div class="container">
        <form action="conform.php" method="post">
            
            <div class="form-group">
                <label for="name">お名前:</label>
                <input type="text" id="name" name="name" required value="<?php echo $old_data['name']; ?>">
            </div>
            
            <div class="form-group">
                <label for="age">年齢:</label>
                <input type="number" id="age" name="age" required value="<?php echo $old_data['age']; ?>">
            </div>
            
            <div class="form-group">
                <label for="phone">電話番号:</label>
                <input type="tel" id="phone" name="phone" required value="<?php echo $old_data['phone']; ?>">
            </div>
            
            <div class="form-group">
                <label for="email">メールアドレス:</label>
                <input type="email" id="email" name="email" required value="<?php echo $old_data['email']; ?>">
            </div>
            
            <div class="form-group">
                <label for="address">住所:</label>
                <input type="text" id="address" name="address" required value="<?php echo $old_data['address']; ?>">
            </div>
            
            <div class="form-group">
                <label for="gender">性別:</label>
                <select id="gender" name="gender">
                    <option value="unselected">選択してください</option>
                    <option value="male" <?php echo $old_data['gender'] == 'male' ? 'selected' : ''; ?>>男性</option>
                    <option value="female" <?php echo $old_data['gender'] == 'female' ? 'selected' : ''; ?>>女性</option>
                    <option value="other" <?php echo $old_data['gender'] == 'other' ? 'selected' : ''; ?>>その他</option>
                </select>
            </div>
            
            <div class="submit-button-wrap">
                <button type="submit" id="submit-btn" name="submit">確認画面へ</button>
            </div>
        </form>
    </div>
</body>
</html>