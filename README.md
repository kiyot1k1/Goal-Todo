# サイト名
目標 & TODOリスト

# 概要説明（サービス内容）
1週間や1日等における「目標」と、その目標達成のために必要な「TODO」の両方を可視化、管理するツール

# 制作理由
TODO管理は、先に1週間や1日等の目標があり、それを踏まえて管理しないと、抜け漏れや優先順位を間違えてしまう可能性があるため、1つのツールで両方を可視化できるものを以前から欲しかったからです。<br>
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
* 完了したTODOのチェック
* 削除

## 今後搭載予定の機能
* レスポンシブデザイン
* ログイン、個人ページ
* 先1週間の目標とTODOを日にちと曜日と共に表示

# 開発環境と取り入れた理由
* DockerでのLEMP環境：いずれ実務でDockerの使用が必要になると思ったため
* MVCモデル：PHPのフレームワークでいずれ学ぶ必要があると思ったため
* visual studio code：複数を使った上で1番使いやすかったため

# 使用技術と選定理由
* PHP：web業界で需要が高く、実務でも使用されることが多いと考えたため
* jQuery：Javascriptより手軽に動きを出したかったため、学ぶきっかけにしたかったため、jQueryにてAjaxを使った非同期通信を取り入れたかったため
* Bootstrap：学ぶきっかけにしたかったため
* Ajax：完了したTODOにチェックを付けた際に、非同期でそのTODOの色がグレーになりラインが引かれることで、その瞬間により達成感を感じられると思ったため


# 工夫したこと
* TODOが完了してチェックした際の非同期通信です。<br>まず前提として、完了したTODOは後で何ができたかを把握するためと、達成感を感じるためにも残しておきたいと考えておりました。<br>その上で、完了したTODOのチェックを付けると、非同期でTODOの色がグレーになり線が引かれることで、視覚的に完了かどうかが分かりやすく、かつチェックを付けた際に非同期で表示が変わることで達成感が感じられると思い、こだわりました。

# 苦労したこと
* Dockerでの環境構築です。実務をするようになれば必要だと思ったので、色々な人のYouTubeやサイトを見ながら行いました。<br>ついにできたかと思えば、今度は初歩的なことですが作業ディレクトリに入れておらず、compose up -dが出来ずに苦労したりもながら、時間はかかりましたが何とか構築できました。<br>また、自分でDockerファイルを一から作ってはいませんが、imageを変えたりはしました。

* 上記の工夫したことにあるTODOのチェック時での非同期通信と表示の調整です。

* 「目標」の削除ボタンを押下した際に、「unexpected token < in json at position 0 ajax」のエラーが出て、解決するのに時間がかかりました。ずっとjQueryの所に原因があると思っていましたが、実際はモデルのSQL文が原因でした。具体的には、WHERE句のidに代入する変数名が間違えておりました。<br>結果的に初歩的なことでしたが、エラー出た際は視野を広げ、疑いの目を持ってプログラムを順番にたどりながら、合理的に問題箇所を絞り込むことが大切だと感じました。

* プログラミングの勉強全般に言えることですが、独学だったことです。<br>自分で何をどう勉強していくか調べたり、考えたりしながら進めるのはやりがいはあったものの、やはりエラーが出た時に聞ける人がいないのが大変でした。一つのエラーが何日も解決しないこと等もありましたが、その分何とか自分で原因を追求して解決できると思えたことが良かったです。<br>勿論、今後はもっと複雑になってくると思いますが、一つ一つの経験を生かし、同じミスをしない、もしエラーが出ても早期解決できるようにしていきたいと思います。
