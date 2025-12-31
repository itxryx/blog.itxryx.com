import { defineCollection, z } from 'astro:content';
import { glob } from 'astro/loaders';

const blog = defineCollection({
	// Load Markdown and MDX files in the `src/content/blog/` directory.
	loader: glob({ base: './src/content/blog', pattern: '**/*.{md,mdx}' }),
	// Type-check frontmatter using a schema
	schema: ({ image }) =>
		z.object({
			title: z.string(),
			description: z.string(),
			slug: z.string().optional(),
			isDraft: z.boolean().default(false),
			category: z.string().optional(),
			tags: z.array(z.string()).default([]),
			heroImage: image().nullable().optional(),
			ogImage: image().nullable().optional(),
			publishedAt: z.coerce.date().nullable().optional(),
			updatedAt: z.coerce.date().nullable().optional(),
		}),
});

export const collections = { blog };
