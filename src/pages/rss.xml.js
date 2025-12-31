import { getCollection } from 'astro:content';
import rss from '@astrojs/rss';
import { SITE_DESCRIPTION, SITE_TITLE } from '../consts';

export async function GET(context) {
	const posts = await getCollection('blog');
	return rss({
		title: SITE_TITLE,
		description: SITE_DESCRIPTION,
		site: context.site,
		items: posts
			.filter((post) => post.data.publishedAt != null)
			.map((post) => ({
				title: post.data.title,
				description: post.data.description,
				pubDate: post.data.publishedAt,
				link: `/blog/${post.id}/`,
			})),
	});
}
