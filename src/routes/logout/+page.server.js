/** @type {import('./$types').LayoutServerLoad} */
import { redirect } from '@sveltejs/kit'

export const actions = {
    default({ cookies }) {
      // eat the cookie
      cookies.set('user', '', {
        path: '/',
        expires: new Date(0),
      })

    console.log('Logout Action Hit');

  
      // redirect the user
      throw redirect(302, '/')
    },
  }
  