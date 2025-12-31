import { existsSync, writeFileSync } from 'node:fs';
import { join } from 'node:path';

/**
 * 16桁のランダムな英数字小文字を生成
 */
function generateRandomString(): string {
	const chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
	let result = '';
	for (let i = 0; i < 16; i++) {
		result += chars.charAt(Math.floor(Math.random() * chars.length));
	}
	return result;
}

/**
 * 現在の日付をYYYY-MM-DD形式で取得
 */
function getCurrentDate(): string {
	const now = new Date();
	const year = now.getFullYear();
	const month = String(now.getMonth() + 1).padStart(2, '0');
	const day = String(now.getDate()).padStart(2, '0');
	return `${year}-${month}-${day}`;
}

/**
 * Frontmatterテンプレートを生成
 */
function generateTemplate(): string {
	return `---
title:
description:
slug:
isDraft: true
category:
tags:
heroImage:
ogImage:
publishedAt:
updatedAt:
---

`;
}

function main() {
	const date = getCurrentDate();
	const randomString = generateRandomString();
	const filename = `${date}-${randomString}.md`;
	const filepath = join(process.cwd(), 'src', 'content', 'blog', filename);

	// ファイルが既に存在する場合はエラー
	if (existsSync(filepath)) {
		console.error(`エラー: ファイル "${filename}" は既に存在します`);
		process.exit(1);
	}

	// テンプレートを生成して書き込み
	const template = generateTemplate();
	writeFileSync(filepath, template, 'utf-8');

	console.log(`✅ 新しい記事テンプレートを作成しました: ${filename}`);
	console.log(`   パス: ${filepath}`);
}

main();
