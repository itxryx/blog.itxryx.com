---
title: git submoduleでupdateができなかった
description: git submoduleでupdateができなかった
slug: could-not-run-git-submodule-update
isDraft: false
category: git
tags:
  - git
  - git-submodule
heroImage:
ogImage:
publishedAt: 2026-02-05
updatedAt:
---

git submoduleを使うプロジェクトに参加しているが、`git submodule update --init --recursive`がなぜか失敗する。

`.git/config`を見てみるとsubmoduleのURLがなぜかHTTPSになっていたので、これをSSHに変更することで解決した。

```
[core]
...
[submodule "path/to/submodule"]↲
-active = true↲
-url = git@github.com:organization/repos.git↲
```

`git config`を叩いても反映できる。

```
git config submodule.path/to/submodule.url git@github.com:organization/repos.git
```

コマンドが用意されているのでコマンドを使うべきですね。

それにしても、PATの発行が必要でめんどくさいHTTPS方式がなぜ使われていたのか、謎。
