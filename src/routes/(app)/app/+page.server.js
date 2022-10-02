/** @type {import('./$types').LayoutServerLoad} */
import { redirect } from '@sveltejs/kit'

export async function load({locals}) {

    if (!locals.user) {
        throw redirect(302, '/')
    }
}