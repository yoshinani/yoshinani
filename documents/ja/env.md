# オプション

- デフォルトの値は `.env.example` に定義されている値を指します

|キー名|条件|型|デフォルト|備考|
|:--|:--|:--|:--|:--|
|`TIMEZONE`|-|`String`|`Asia/Tokyo`|JST(日本標準時)に設定済み|
|`LOCALE`|-|`String`|`ja`|日本語に設定済み|
|`LOG_CHANNEL`|-|`String`|`daily`|ログを日別で出力するように設定済み|
|`LOG_ROTATED_DAYS`|`LOG_CHANNEL = daily`|`Int`|`30`|30日間ログを保持するように設定済み|
|`LOG_SLACK_WEBHOOK_URL`|`LOG_CHANNEL = slack`|`String`|-|slackでロギングする際はWebhookURLを記述|
|`LOG_SLACK_USERNAME`|`LOG_CHANNEL = slack`|`String`|`-`|slackでロギング結果を出力するボットの名称|
|`USE_SOCIAL`|-|`Boolean`|`false`|true時、ルートと画面どちらもSocialLoginの機能を有効化します|
|`FACEBOOK_CLIENT_ID`|`USE_SOCIAL = true`|`String`|-|OAuthアプリケーションの登録が必要です|
|`FACEBOOK_CLIENT_SECRET`|`USE_SOCIAL = true`|`String`|-|OAuthアプリケーションの登録が必要です|
|`FACEBOOK_CALLBACK_URL`|`USE_SOCIAL = true`|`String`|http://yoshinani.homestead/auth/facebook/callback||
|`TWITTER_CLIENT_ID`|`USE_SOCIAL = true`|`String`|-|OAuthアプリケーションの登録が必要です|
|`TWITTER_CLIENT_SECRET`|`USE_SOCIAL = true`|`String`|-|OAuthアプリケーションの登録が必要です|
|`TWITTER_CALLBACK_URL`|`USE_SOCIAL = true`|`String`|http://yoshinani.homestead/auth/twitter/callback||
|`GITHUB_CLIENT_ID`|`USE_SOCIAL = true`|`String`|-|OAuthアプリケーションの登録が必要です|
|`GITHUB_CLIENT_SECRET`|`USE_SOCIAL = true`|`String`|-|OAuthアプリケーションの登録が必要です|
|`GITHUB_CALLBACK_URL`|`USE_SOCIAL = true`|`String`|http://yoshinani.homestead/auth/github/callback||
