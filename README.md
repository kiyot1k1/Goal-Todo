# サイト名
目標 & TODOリスト

# 概要説明（サービス内容）
「目標」とその達成のために必要な「TODO」の両方を可視化、管理するツール

# 制作理由
TODOを管理するにあたり、先に1週間や1日等の目標があり、それを踏まえてTODOを管理しないと、抜け漏れや優先順位を間違えてしまう可能性があるため、1つのツールで両方を可視化できるものを以前から欲しかったからです。<br>
また、データベースでのCRUD機能等、制作を通して理解を深めたい技術も使用できるからです。

# 実装機能
## 目標
* 一覧表示
* 新規作成
* 編集
* 削除

## TODO
* 一覧表示
* 詳細表示
* 新規作成
* 編集
* 完了したTODOのチェック（非同期通信）
* 削除

## 全般
* ログイン、個人ページ
* レスポンシブデザイン

# 開発環境と取り入れた理由
* DockerでのLEMP環境：実務で使用する時に向け経験しておきたかったため
* MVCモデル：PHPのフレームワークに向けて先んじて経験するため
* visual studio code：複数を使った上で1番使いやすかったため

# 使用技術と選定理由
* PHP：DBと接続し使用する言語の中でも、特にWeb業界で需要が高いと思ったため
* jQuery：Ajaxを使いたかったのと、純粋に学んだことを実際に使用してみたかったため
* Bootstrap：手軽にデザインに変化を付けたかったため

# こだわったこと
* TODOが完了してチェックした際の非同期通信です。まず前提として、完了したTODOをチェック後も把握するためと、視覚的に達成感を感じるためにも一回で削除して消さずに残しておきたいと考えておりました。<br>よって、チェックを付けると非同期でTODOの色がグレーになり線が引かれ、視覚的に完了かどうかが分かりやすく、かつその際に非同期で表示が変わることでチェックを付けた時により達成感が感じられると思い、こだわりました。

* Dockerファイル（Docker on HEROKUでの公開）

# 苦労したこと
* Dockerでの環境構築です。実務で必要になることが出てくると思ったので、色々な人のYouTubeやサイトを見ながら行いました。ついに構築できたかと思えば、今度は初歩的なことですが「cd」で作業ディレクトリに入れておらず、「docker-compose up -d」が出来ない等、色々と苦労しました。

* 「目標」の削除ボタンを押下した際に、「unexpected token < in json at position 0 ajax」のエラーが出て、解決するのに時間がかかりました。ずっとjQueryの所に原因があると思っていましたが、実際はモデルのSQL文が原因で、具体的には、WHERE句のidに代入する変数名が間違えておりました。結果的に初歩的なことでしたが、エラーが出た際は視野を広げ、疑いの目を持ってプログラムを順番にたどりながら、合理的に問題箇所を絞り込むことが大切だと感じました。

* HEROKUで公開作業をしていた際にデプロイが上手くいかず、「No default language could be detected for this app.」のエラーに悩まされました。原因はルートに「composer.json」と「index.php」両方がなかったためで、両ファイルをルートに配置することで解消できました。
