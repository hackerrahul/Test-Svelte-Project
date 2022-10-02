import { invalid, redirect } from '@sveltejs/kit';

export async function load({locals}) {

    if(locals.user) {
        throw redirect(302, '/app')
    }
}

export const actions = {
	login: async ({ request, cookies }) => {
		const form = await request.formData();

        const email = form.get('email');
        const password = form.get('password');

        if(!email && !password) {
            return invalid(400,{ email_invalid: true, password_invalid: true})
        }

        if(!email) {
            return invalid(400,{ email_invalid: true})
        }

        if(!password) {
            return invalid(400,{password_invalid: true})
        }
        const login_api = fetch(import.meta.env.VITE_API_BASE_URL+"/login.php",{
            method:'POST',
            body:form
        });

        const res = await login_api.json();
        
        if(res.status == "error"){
            return invalid(400,{backend_error: res.message});
        }

        cookies.set('user', res.access_token, {
            // send cookie for every page
            path: '/',
            httpOnly: true,
            sameSite: 'strict',
            secure: process.env.NODE_ENV === 'production',
            maxAge: 60 * 60 * 24 * 30,
        })

        throw redirect(302, '/app')
        
        

	},
}