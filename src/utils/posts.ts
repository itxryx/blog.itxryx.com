import { getCollection, type CollectionEntry } from 'astro:content';

/**
 * すべてのブログ記事を取得し、publishedAt降順でソート
 */
export async function getSortedPosts(): Promise<CollectionEntry<'blog'>[]> {
	const posts = await getCollection('blog');
	return posts.sort((a, b) => {
		const dateA = a.data.publishedAt?.valueOf() ?? 0;
		const dateB = b.data.publishedAt?.valueOf() ?? 0;
		return dateB - dateA;
	});
}

/**
 * 公開済みのブログ記事のみを取得（isDraft=false かつ publishedAt設定済み）
 * publishedAt降順でソート
 */
export async function getPublishedPosts(): Promise<CollectionEntry<'blog'>[]> {
	const posts = await getCollection('blog');
	return posts
		.filter((post) => !post.data.isDraft && post.data.publishedAt != null)
		.sort((a, b) => {
			const dateA = a.data.publishedAt!.valueOf();
			const dateB = b.data.publishedAt!.valueOf();
			return dateB - dateA;
		});
}
